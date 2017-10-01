<?php
use Interop\Http\ServerMiddleware\DelegateInterface;
use Zend\Diactoros\Response\TextResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\AppFactory;
use Tictactoe\Gameplay;
use Tictactoe\Cell;
use Tictactoe\Players\HumanPlayer;
use Tictactoe\Players\RandomizedComputerPlayer;
use Tictactoe\Exceptions\CellIsNotEmptyException;
use Tictactoe\Exceptions\DrawException;

chdir(dirname(__DIR__));
require '../../../../../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function ($request, DelegateInterface $delegate) {
    if (!isset($_COOKIE['game'])) {
        $human = new HumanPlayer();
        $computer = new RandomizedComputerPlayer();
        $game = new Gameplay($human, $computer);
        setcookie('player1', serialize($human), time() + 3600, '/');
        setcookie('player2', serialize($computer), time() + 3600, '/');
        setcookie('game', serialize($game), time() + 3600, '/');
    }
    require_once 'views/board.php';
});
$app->post('/p1_turn/', function ($request, DelegateInterface $delegate) {
    if (!isset($_COOKIE['player1']) || !isset($_COOKIE['player2']) || !isset($_COOKIE['game'])) {
        return new TextResponse('Server error');
    }
    $human = unserialize($_COOKIE['player1']);
    $computer = unserialize($_COOKIE['player2']);
    $game = unserialize($_COOKIE['game']);
    list($x, $y) = explode(', ', $_POST['cell']);
    try {
        $human->makeTurn(new Cell($x, $y));
        $computer->makeRandomizedTurn();
        var_dump($game->getEmptyBoard());
        setcookie('player1', serialize($human), time() + 3600, '/');
        setcookie('player2', serialize($computer), time() + 3600, '/');
        setcookie('game', serialize($game), time() + 3600, '/');
        return new JsonResponse();
    } catch (CellIsNotEmptyException $e) {
        return new JsonResponse('failure', 403);
    } catch (DrawException $e) {
        return new JsonResponse('draw', 205);
    }

});
$app->get('/gameover', function ($request, DelegateInterface $delegate) {
    setcookie('player1', '', time() - 3600, '/');
    setcookie('player2', '', time() - 3600, '/');
    setcookie('game', '', time() - 3600, '/');
});
$app->pipeRoutingMiddleware();
$app->pipeDispatchMiddleware();
$app->run();
