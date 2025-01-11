import { $vfm } from 'vue-final-modal';
import { toRefs, ref } from 'vue';
import AddMissModal from '../Components/Modals/AddMissModal.vue';
import AddScoreModal from '../Components/Modals/AddScoreModal.vue';
import AddSubstitutionModal from '../Components/Modals/AddSubstitutionModal.vue';
import AddTimeoutModal from '../Components/Modals/AddTimeoutModal.vue';
import AddFoulModal from '../Components/Modals/AddFoulModal.vue';
import AddReboundModal from '../Components/Modals/AddReboundModal.vue';
import AddStealModal from '../Components/Modals/AddStealModal.vue';
import AddBlockModal from '../Components/Modals/AddBlockModal.vue';
import AddTurnoverModal from '../Components/Modals/AddTurnoverModal.vue';

export default {
    checkIfCanUpdateStats: function (game) {
        console.log(game);

        if (game.status === 'pending') {
            alert('Da bi ste promijenili statistiku, trebate započeti utakmicu.');
            return false;
        }

        if (game.status === 'ended') {
            alert('Utakmica je zavrsila.');
            return false;
        }

        if (game.status === 'started') {
            return true;
        } else {
            alert('Nepoznat status utakmice [' + game.status + ']');
            return false;
        }
    },

    addScore: function (game, team, player = null) {
        if (this.checkIfCanUpdateStats(game)) {
            $vfm.show({ component: AddScoreModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team), player: player } });
        }
    },

    addMiss: function (game, team) {
        if (this.checkIfCanUpdateStats(game)) {
            $vfm.show({ component: AddMissModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team) } });
        }
    },

    addSubstitution: function (game, team, playerIn = null, playerOut = null) {
        if (playerIn && playerIn.stats.fouls >= 5) {
            alert('Ovaj igrač ima 5 prekršaja');
            return;
        }

        if (this.checkIfCanUpdateStats(game)) {
            if (playerIn) $vfm.show({ component: AddSubstitutionModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team), playersOnBench: this.playersOnBench(game, team), playerIn: playerIn } });
            else if (playerOut) $vfm.show({ component: AddSubstitutionModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team), playersOnBench: this.playersOnBench(game, team), playerOut: playerOut } });
            else $vfm.show({ component: AddSubstitutionModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team), playersOnBench: this.playersOnBench(game, team) } });
        }
    },

    addTimeout: function (game, team) {
        if (this.checkIfCanUpdateStats(game)) {
            $vfm.show({ component: AddTimeoutModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team), playersOnBench: this.playersOnBench(game, team) } });
        }
    },

    addFoul: function (game, team, type) {
        if (this.checkIfCanUpdateStats(game)) {
            $vfm.show({ component: AddFoulModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team), opponentPlayers: this.opponentPlayersOnCourt(game, team), type: type } });
        }
    },

    addAssist: function (game, team) {
        if (this.checkIfCanUpdateStats(game)) {
            alert('Assist: ' + type);
        }
    },

    addBlock: function (game, team) {
        if (this.checkIfCanUpdateStats(game)) {
            $vfm.show({ component: AddBlockModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team), opponentPlayers: this.opponentPlayersOnCourt(game, team) } });
        }
    },

    addTurnover: function (game, team) {
        if (this.checkIfCanUpdateStats(game)) {
            $vfm.show({ component: AddTurnoverModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team) } });
        }
    },

    addSteal: function (game, team) {
        if (this.checkIfCanUpdateStats(game)) {
            $vfm.show({ component: AddStealModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team), opponentPlayers: this.opponentPlayersOnCourt(game, team) } });
        }
    },

    addRebound: function (game, team, type = 'reb') {
        if (this.checkIfCanUpdateStats(game)) {
            $vfm.show({ component: AddReboundModal, bind: { game: game, team: team, players: this.playersOnCourt(game, team) } });
        }
    },

    opponentTeam: function (game, team) {
        if (team.id === game.home_team.id) {
            return game.away_team;
        } else {
            return game.home_team;
        }
    },

    opponentPlayers: function (game, team) {
        if (team.id === game.home_team.id) {
            return game.away_players;
        } else {
            return game.home_players;
        }
    },

    opponentPlayersOnCourt: function (game, team) {
        if (team.id === game.home_team.id) {
            return game.away_players_on_court;
        } else {
            return game.home_players_on_court;
        }
    },

    playersOnCourt: function (game, team) {
        if (team.id === game.home_team.id) {
            return game.home_players_on_court;
        } else {
            return game.away_players_on_court;
        }
    },

    playersOnBench: function (game, team) {
        if (team.id === game.home_team.id) {
            return game.home_players_on_bench;
        } else {
            return game.away_players_on_bench;
        }
    },

    checkPlayersForFouls: function (game) {
        let allPlayersOnCourt = this.playersOnCourt(game, game.home_team).concat(this.playersOnCourt(game, game.away_team));

        this.playersOnCourt(game, game.home_team).forEach((player) => {
            if (player.stats.fouls >= 5) {
                this.addSubstitution(game, game.home_team, null, player);
            }
        });

        this.playersOnCourt(game, game.away_team).forEach((player) => {
            if (player.stats.fouls >= 5) {
                this.addSubstitution(game, game.away_team, null, player);
            }
        });
    },

    pluck: function(arr, key) {
        return arr.map(i => i[key]);
    },

    __: function (str) {
        return str;
    },
};
