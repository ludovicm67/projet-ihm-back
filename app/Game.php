<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
  protected $nbPlayers;
  protected $players;
  protected $deck;
  protected $nbWinningRounds;
  protected $id;

  public function createGame($players, $nbPlayers, $deck)
  {
    $players = $players;
    $nbPlayers = $nbp;
    $deck = $deck;
    if ($nbPlayers == 2) {
      $nbWinningRounds = 7;
    } elseif ($nbPlayers == 3) {
      $nbWinningRounds = 5;
    } else {
      $nbWinningRounds = 4;
    }
  }

  //id ?

  // @FIXME: attention, ce code est invalide !
  //     createRound(players,deck,id);
  // }
}