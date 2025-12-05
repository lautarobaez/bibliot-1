const WebSocket = require('ws');

const PORT = process.env.WS_PORT || 8081;
const server = new WebSocket.Server({ port: PORT });

/**
 * Mapa que asocia cada socket con los datos del usuario autenticado.
 */
const onlineUsers = new Map();

function getOnlineUsers() {
  return Array.from(onlineUsers.values()).sort((a, b) =>
    a.username.localeCompare(b.username, 'es', { sensitivity: 'base' })
  );
}

/**
 * Envía a todos los clientes la lista actualizada de usuarios conectados.
 */
function broadcastOnlineUsers() {
  const payload = JSON.stringify({
    type: 'ONLINE_USERS',
    onlineUsers: getOnlineUsers(),
  });

  server.clients.forEach((client) => {
    if (client.readyState === WebSocket.OPEN) {
      client.send(payload);
    }
  });
}

function disconnectDuplicatedSessions(username, currentSocket) {
  for (const [socket, user] of onlineUsers.entries()) {
    if (socket !== currentSocket && user.username === username) {
      try {
        socket.close(4001, 'Sesión duplicada');
      } catch (error) {
        console.error('No se pudo cerrar la sesión duplicada', error);
      }
      onlineUsers.delete(socket);
    }
  }
}

function registerUser(socket, data) {
  const username = String(data.username || '').trim();
  if (!username) {
    return;
  }

  disconnectDuplicatedSessions(username, socket);

  onlineUsers.set(socket, {
    username,
    role: data.role || 'usuario',
    connectedAt: Date.now(),
  });

  broadcastOnlineUsers();
}

/**
 * Pings periódicos para limpiar conexiones caídas.
 */
const heartbeatInterval = setInterval(() => {
  server.clients.forEach((socket) => {
    if (socket.isAlive === false) {
      return socket.terminate();
    }

    socket.isAlive = false;
    socket.ping();
  });
}, 30000);

server.on('connection', (socket) => {
  socket.isAlive = true;

  socket.on('pong', () => {
    socket.isAlive = true;
  });

  socket.on('message', (incoming) => {
    let data;
    try {
      data = JSON.parse(incoming.toString());
    } catch (error) {
      console.error('Mensaje inválido recibido', error);
      return;
    }

    if (data.type === 'REGISTER') {
      registerUser(socket, data);
      return;
    }

    if (data.type === 'PING') {
      socket.send(JSON.stringify({ type: 'PONG' }));
    }
  });

  socket.on('close', () => {
    onlineUsers.delete(socket);
    broadcastOnlineUsers();
  });

  socket.on('error', (error) => {
    console.error('Error en WebSocket', error);
  });
});

server.on('close', () => {
  clearInterval(heartbeatInterval);
});

console.log(`Servidor WebSocket listo en ws://localhost:${PORT}`);

