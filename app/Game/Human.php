<?php
namespace App\Game;

use App\Game\Play;

class Human
{
  /* a human player is playing
   * $params can contain :
   * action
   * played_card
   * choosen_player
   * choosen_card_name
   */
  public static function play($state, $params)
  {
    $state->players[$state->current_player]->immunity = false;
    // put immunity to false, in case it was true
    $user = auth()->user(); // if need to do something with the user informations

    if ($params['action'] == 'pick_card') {
      if (count($state->players[$state->current_player]->hand) == 1) {
        $state = Play::pickCard($state);
      }
    } elseif ($params['action'] == 'play_card') {
      $key_card = array_search(
        $params['played_card'],
        array_column($state->players[$state->current_player]->hand, 'value')
      ); // discard the card that has been played
      array_push($state->current_round->played_cards, [
        $state->current_player,
        $state->players[$state->current_player]->hand[$key_card]
      ]);
      if ($key_card == 0) {
        array_shift($state->players[$state->current_player]->hand);
      } elseif ($key_card == 1) {
        array_pop($state->players[$state->current_player]->hand);
      }

      if ($params['played_card'] == 1) {
        // Soldier
        if (
          $params['choosen_card_name'] ==
          $state->players[$params['choosen_player']]->hand[0]->card_name
        ) {
          $state = Play::playerHasLost($state, $params['choosen_player']);
        }
      } elseif ($params['played_card'] == 3) {
        // Knight
        if (
          $state->players[$state->current_player]->hand[0]->value >
          $state->players[$params['choosen_player']]->hand[0]->value
        ) {
          $state = Play::playerHasLost($state, $params['choosen_player']);
        } elseif (
          $state->players[$state->current_player]->hand[0]->value <
          $state->players[$params['choosen_player']]->hand[0]->value
        ) {
          $state = Play::playerHasLost($state, $state->current_player);
        }
      } elseif ($params['played_card'] == 4) {
        // Priestess
        $state->players[$state->current_player]->immunity = true;
      } elseif ($params['played_card'] == 5) {
        // Sorcerer
        array_push($state->current_round->played_cards, [
          $params['choosen_player'],
          $state->players[$params['choosen_player']]->hand[0]
        ]);
        array_pop($state->players[$params['choosen_player']]->hand);
        $state = Play::pickCard($state);
      } elseif ($params['played_card'] == 6) {
        // General
        $card = $state->players[$state->current_player]->hand[0];
        $state->players[$state->current_player]->hand[0] = $state->players[
          $params['choosen_player']
        ]->
          hand[0];
        $state->players[$params['choosen_player']]->hand[0] = $card;
      } elseif ($params['played_card'] == 8) {
        // Princess/Prince
        $state = Play::playerHasLost($state, $state->current_player);
      }

      /*
      if(count($state->current_round->pile) == 0)
      {
        // end of the round
      }

      if(count($state->current_round->current_players) == 1))
      {
      // end of the round
      }
    */

      // just a test
      $state->test[] = $params;
      $state = Play::nextPlayer($state);
    }
    return $state;
  }
}