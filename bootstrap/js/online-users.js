(function () {
  if (!window.wsConfig || !window.wsConfig.url || !window.wsConfig.username) {
    return;
  }

  var socket;
  var reconnectTimer;
  var indicator = document.getElementById('onlineUsersIndicator');
  var listContainer = document.getElementById('onlineUsersList');
  var statusBadge = indicator ? indicator.querySelector('.count') : null;
  var statusText = indicator ? indicator.querySelector('.status-text') : null;

  function setConnectionState(isConnected) {
    if (!indicator) {
      return;
    }

    var connected = Boolean(isConnected && socket && socket.readyState === WebSocket.OPEN);
    indicator.classList.toggle('online-users-indicator--connected', connected);
    indicator.classList.toggle('online-users-indicator--disconnected', !connected);

    if (statusText) {
      statusText.textContent = connected ? 'Usuarios conectados' : 'Reconectando...';
    }
  }

  function updateCount(total) {
    if (statusBadge) {
      statusBadge.textContent = total;
    }
  }

  function formatRelativeTime(timestamp) {
    if (!timestamp) {
      return '';
    }

    var diffSeconds = Math.max(0, Math.floor((Date.now() - timestamp) / 1000));
    var value;
    var suffix;

    if (diffSeconds < 60) {
      value = diffSeconds;
      suffix = 'seg';
    } else if (diffSeconds < 3600) {
      value = Math.floor(diffSeconds / 60);
      suffix = 'min';
    } else if (diffSeconds < 86400) {
      value = Math.floor(diffSeconds / 3600);
      suffix = 'h';
    } else {
      value = Math.floor(diffSeconds / 86400);
      suffix = 'd';
    }

    return 'Conectado hace ' + value + ' ' + suffix;
  }

  function renderList(users) {
    if (!listContainer) {
      return;
    }

    if (!Array.isArray(users) || users.length === 0) {
      listContainer.innerHTML = '<li class="text-muted">Sin usuarios activos</li>';
      updateCount(0);
      return;
    }

    var fragment = document.createDocumentFragment();

    users.forEach(function (user) {
      var item = document.createElement('li');

      var label = document.createElement('span');
      label.textContent = user.username + (user.role ? ' (' + user.role + ')' : '');
      item.appendChild(label);

      if (user.connectedAt) {
        var meta = document.createElement('small');
        meta.textContent = formatRelativeTime(user.connectedAt);
        item.appendChild(meta);
      }

      fragment.appendChild(item);
    });

    listContainer.innerHTML = '';
    listContainer.appendChild(fragment);
    updateCount(users.length);
  }

  function scheduleReconnect() {
    if (reconnectTimer) {
      clearTimeout(reconnectTimer);
    }

    reconnectTimer = setTimeout(connect, 4000);
    setConnectionState(false);
    updateCount(0);
  }

  function connect() {
    try {
      socket = new WebSocket(window.wsConfig.url);
    } catch (error) {
      console.error('No se pudo inicializar WebSocket', error);
      scheduleReconnect();
      return;
    }

    socket.addEventListener('open', function () {
      setConnectionState(true);

      var payload = {
        type: 'REGISTER',
        username: window.wsConfig.username,
        role: window.wsConfig.role,
      };

      socket.send(JSON.stringify(payload));
    });

    socket.addEventListener('message', function (event) {
      var data;
      try {
        data = JSON.parse(event.data);
      } catch (error) {
        console.warn('Mensaje no válido recibido', error);
        return;
      }

      if (data.type === 'ONLINE_USERS') {
        renderList(data.onlineUsers || []);
      }
    });

    socket.addEventListener('close', function () {
      scheduleReconnect();
    });

    socket.addEventListener('error', function () {
      if (socket && socket.readyState !== WebSocket.CLOSED) {
        socket.close();
      }
    });
  }

  window.addEventListener('beforeunload', function () {
    if (socket && socket.readyState === WebSocket.OPEN) {
      socket.close();
    }
  });

  setConnectionState(false);
  connect();
})();

