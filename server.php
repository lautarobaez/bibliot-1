<?php
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require __DIR__ . '/vendor/autoload.php';

class UserConnectionServer implements MessageComponentInterface {
    protected $clients;
    protected $userList = [];

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);

        if ($data['type'] === 'login') {
            $this->userList[$from->resourceId] = $data['username'];
        } elseif ($data['type'] === 'logout') {
            unset($this->userList[$from->resourceId]);
        }

        foreach ($this->clients as $client) {
            $client->send(json_encode([
                'type' => 'update',
                'users' => array_values($this->userList)
            ]));
        }
    }

    public function onClose(ConnectionInterface $conn) {
        unset($this->userList[$conn->resourceId]);
        $this->clients->detach($conn);

        foreach ($this->clients as $client) {
            $client->send(json_encode([
                'type' => 'update',
                'users' => array_values($this->userList)
            ]));
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

$server = Ratchet\Server\IoServer::factory(
    new Ratchet\Http\HttpServer(
        new Ratchet\WebSocket\WsServer(
            new UserConnectionServer()
        )
    ),
    8080
);

echo "Servidor WebSocket iniciado en el puerto 8080\n";
$server->run();
