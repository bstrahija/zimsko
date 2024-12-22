<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $external_id
 * @property string|null $slug
 * @property string $title
 * @property string $body
 * @property string $status
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Category withoutTrashed()
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int|null $external_id
 * @property string|null $slug
 * @property string $name
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property string|null $status
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Coach withoutTrashed()
 */
	class Coach extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int|null $external_id
 * @property string|null $slug
 * @property string $title
 * @property string|null $body
 * @property string $status
 * @property array|null $data
 * @property int|null $scheduled_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Game> $games
 * @property-read int|null $games_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Stat> $stats
 * @property-read int|null $stats_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Event withoutTrashed()
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @package App\Models
 * @property string $id
 * @property int|null $external_id
 * @property string $event_id
 * @property int|null $round_id
 * @property string|null $slug
 * @property string $title
 * @property string|null $body
 * @property string $home_team_id
 * @property string $away_team_id
 * @property int|null $home_wins
 * @property int|null $away_wins
 * @property int|null $home_losses
 * @property int|null $away_losses
 * @property int|null $home_score
 * @property int|null $away_score
 * @property int|null $home_score_against
 * @property int|null $away_score_against
 * @property int|null $home_score_diff
 * @property int|null $away_score_diff
 * @property int|null $home_score_p1
 * @property int|null $away_score_p1
 * @property int|null $home_score_p1_against
 * @property int|null $away_score_p1_against
 * @property int|null $home_score_p1_diff
 * @property int|null $away_score_p1_diff
 * @property int|null $home_score_p2
 * @property int|null $away_score_p2
 * @property int|null $home_score_p2_against
 * @property int|null $away_score_p2_against
 * @property int|null $home_score_p2_diff
 * @property int|null $away_score_p2_diff
 * @property int|null $home_score_p3
 * @property int|null $away_score_p3
 * @property int|null $home_score_p3_against
 * @property int|null $away_score_p3_against
 * @property int|null $home_score_p3_diff
 * @property int|null $away_score_p3_diff
 * @property int|null $home_score_p4
 * @property int|null $away_score_p4
 * @property int|null $home_score_p4_against
 * @property int|null $away_score_p4_against
 * @property int|null $home_score_p4_diff
 * @property int|null $away_score_p4_diff
 * @property int|null $home_score_p5
 * @property int|null $away_score_p5
 * @property int|null $home_score_p5_against
 * @property int|null $away_score_p5_against
 * @property int|null $home_score_p5_diff
 * @property int|null $away_score_p5_diff
 * @property int|null $home_score_p6
 * @property int|null $away_score_p6
 * @property int|null $home_score_p6_against
 * @property int|null $away_score_p6_against
 * @property int|null $home_score_p6_diff
 * @property int|null $away_score_p6_diff
 * @property int|null $home_score_p7
 * @property int|null $away_score_p7
 * @property int|null $home_score_p7_against
 * @property int|null $away_score_p7_against
 * @property int|null $home_score_p7_diff
 * @property int|null $away_score_p7_diff
 * @property int|null $home_score_p8
 * @property int|null $away_score_p8
 * @property int|null $home_score_p8_against
 * @property int|null $away_score_p8_against
 * @property int|null $home_score_p8_diff
 * @property int|null $away_score_p8_diff
 * @property int|null $home_score_p9
 * @property int|null $away_score_p9
 * @property int|null $home_score_p9_against
 * @property int|null $away_score_p9_against
 * @property int|null $home_score_p9_diff
 * @property int|null $away_score_p9_diff
 * @property int|null $home_score_p10
 * @property int|null $away_score_p10
 * @property int|null $home_score_p10_against
 * @property int|null $away_score_p10_against
 * @property int|null $home_score_p10_diff
 * @property int|null $away_score_p10_diff
 * @property int|null $home_assists
 * @property int|null $away_assists
 * @property int|null $home_steals
 * @property int|null $away_steals
 * @property int|null $home_blocks
 * @property int|null $away_blocks
 * @property int|null $home_turnovers
 * @property int|null $away_turnovers
 * @property int|null $home_fouls
 * @property int|null $away_fouls
 * @property int|null $home_personal_fouls
 * @property int|null $away_personal_fouls
 * @property int|null $home_technical_fouls
 * @property int|null $away_technical_fouls
 * @property int|null $home_flagrant_fouls
 * @property int|null $away_flagrant_fouls
 * @property int|null $home_three_points
 * @property int|null $away_three_points
 * @property int|null $home_three_points_made
 * @property int|null $away_three_points_made
 * @property int|null $home_two_points
 * @property int|null $away_two_points
 * @property int|null $home_two_points_made
 * @property int|null $away_two_points_made
 * @property int|null $home_field_goals
 * @property int|null $away_field_goals
 * @property int|null $home_field_goals_made
 * @property int|null $away_field_goals_made
 * @property int|null $home_free_throws
 * @property int|null $away_free_throws
 * @property int|null $home_free_throws_made
 * @property int|null $away_free_throws_made
 * @property int|null $home_rebounds
 * @property int|null $away_rebounds
 * @property int|null $home_offensive_rebounds
 * @property int|null $away_offensive_rebounds
 * @property int|null $home_defensive_rebounds
 * @property int|null $away_defensive_rebounds
 * @property int|null $home_timeouts
 * @property int|null $away_timeouts
 * @property string|null $status
 * @property array|null $data
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $scheduled_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GamePlayer> $awayGamePlayers
 * @property-read int|null $away_game_players_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $awayPlayers
 * @property-read int|null $away_players_count
 * @property-read \App\Models\Team $awayTeam
 * @property-read \App\Models\Event $event
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GameLog> $gameLogs
 * @property-read int|null $game_logs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GamePlayer> $gamePlayers
 * @property-read int|null $game_players_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GamePlayer> $homeGamePlayers
 * @property-read int|null $home_game_players_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $homePlayers
 * @property-read int|null $home_players_count
 * @property-read \App\Models\Team $homeTeam
 * @property-read \App\Models\GameLive|null $live
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 * @property-read int|null $players_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Referee> $referees
 * @property-read int|null $referees_count
 * @property-read \App\Models\Round|null $round
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Stat> $stats
 * @property-read int|null $stats_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayAssists($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayDefensiveRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayFieldGoals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayFieldGoalsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayFlagrantFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayFreeThrows($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayFreeThrowsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayLosses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayOffensiveRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayPersonalFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreAgainst($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreDiff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP10($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP10Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP10Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP1Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP1Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP2Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP2Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP3Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP3Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP4Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP4Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP5Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP5Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP6($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP6Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP6Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP7($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP7Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP7Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP8($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP8Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP8Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP9($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP9Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayScoreP9Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwaySteals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayTechnicalFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayThreePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayThreePointsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayTimeouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayTurnovers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayTwoPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayTwoPointsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereAwayWins($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeAssists($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeDefensiveRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeFieldGoals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeFieldGoalsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeFlagrantFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeFreeThrows($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeFreeThrowsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeLosses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeOffensiveRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomePersonalFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreAgainst($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreDiff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP10($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP10Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP10Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP1Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP1Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP2Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP2Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP3Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP3Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP4Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP4Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP5Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP5Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP6($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP6Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP6Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP7($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP7Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP7Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP8($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP8Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP8Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP9($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP9Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeScoreP9Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeSteals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeTechnicalFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeThreePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeThreePointsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeTimeouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeTurnovers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeTwoPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeTwoPointsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereHomeWins($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereRoundId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game withoutTrashed()
 */
	class Game extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $game_id
 * @property string $status
 * @property int $home_score
 * @property int $away_score
 * @property int $home_score_p1
 * @property int $away_score_p1
 * @property int $home_score_p2
 * @property int $away_score_p2
 * @property int $home_score_p3
 * @property int $away_score_p3
 * @property int $home_score_p4
 * @property int $away_score_p4
 * @property int|null $home_score_p5
 * @property int|null $away_score_p5
 * @property int|null $home_score_p6
 * @property int|null $away_score_p6
 * @property int|null $home_score_p7
 * @property int|null $away_score_p7
 * @property int|null $home_score_p8
 * @property int|null $away_score_p8
 * @property int|null $home_score_p9
 * @property int|null $away_score_p9
 * @property int|null $home_score_p10
 * @property int|null $away_score_p10
 * @property int $period
 * @property array|null $home_starting_players
 * @property array|null $away_starting_players
 * @property array|null $home_players_on_court
 * @property array|null $away_players_on_court
 * @property array|null $home_players
 * @property array|null $away_players
 * @property int $home_timeouts_left
 * @property int $away_timeouts_left
 * @property int $home_fouls_left
 * @property int $away_fouls_left
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Stat> $stats
 * @property-read int|null $stats_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayFoulsLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayPlayers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayPlayersOnCourt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP10($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP6($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP7($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP8($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayScoreP9($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayStartingPlayers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereAwayTimeoutsLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeFoulsLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomePlayers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomePlayersOnCourt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP10($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP6($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP7($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP8($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeScoreP9($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeStartingPlayers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereHomeTimeoutsLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLive whereUpdatedAt($value)
 */
	class GameLive extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $game_id
 * @property string $game_live_id
 * @property string|null $type
 * @property string|null $subtype
 * @property int|null $amount
 * @property int $home_score
 * @property int $away_score
 * @property int $period
 * @property string|null $player_name
 * @property string|null $player_2_name
 * @property string|null $team_name
 * @property string|null $team_side
 * @property string|null $player_id
 * @property string|null $player_2_id
 * @property string|null $team_id
 * @property string|null $coach_id
 * @property string|null $referee_id
 * @property string|null $official_id
 * @property string|null $location
 * @property array|null $data
 * @property string|null $summary
 * @property string|null $occurred_at
 * @property string|null $occurred_at_p
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Coach|null $coach
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\GameLive $gameLive
 * @property-read \App\Models\Official|null $official
 * @property-read \App\Models\Player|null $player
 * @property-read \App\Models\Referee|null $referee
 * @property-read \App\Models\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereAwayScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereCoachId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereGameLiveId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereHomeScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereOccurredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereOccurredAtP($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereOfficialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog wherePlayer2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog wherePlayer2Name($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog wherePlayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereRefereeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereSubtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereTeamName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereTeamSide($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameLog whereUpdatedAt($value)
 */
	class GameLog extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $event_id
 * @property string $game_id
 * @property string $player_id
 * @property string|null $team_id
 * @property int|null $wins
 * @property int|null $losses
 * @property int|null $score
 * @property int|null $score_against
 * @property int|null $score_diff
 * @property int|null $score_p1
 * @property int|null $score_p1_against
 * @property int|null $score_p1_diff
 * @property int|null $score_p2
 * @property int|null $score_p2_against
 * @property int|null $score_p2_diff
 * @property int|null $score_p3
 * @property int|null $score_p3_against
 * @property int|null $score_p3_diff
 * @property int|null $score_p4
 * @property int|null $score_p4_against
 * @property int|null $score_p4_diff
 * @property int|null $score_p5
 * @property int|null $score_p5_against
 * @property int|null $score_p5_diff
 * @property int|null $score_p6
 * @property int|null $score_p6_against
 * @property int|null $score_p6_diff
 * @property int|null $score_p7
 * @property int|null $score_p7_against
 * @property int|null $score_p7_diff
 * @property int|null $score_p8
 * @property int|null $score_p8_against
 * @property int|null $score_p8_diff
 * @property int|null $score_p9
 * @property int|null $score_p9_against
 * @property int|null $score_p9_diff
 * @property int|null $score_p10
 * @property int|null $score_p10_against
 * @property int|null $score_p10_diff
 * @property int|null $assists
 * @property int|null $steals
 * @property int|null $blocks
 * @property int|null $turnovers
 * @property int|null $fouls
 * @property int|null $personal_fouls
 * @property int|null $technical_fouls
 * @property int|null $flagrant_fouls
 * @property int|null $three_points
 * @property int|null $three_points_made
 * @property int|null $two_points
 * @property int|null $two_points_made
 * @property int|null $field_goals
 * @property int|null $field_goals_made
 * @property int|null $free_throws
 * @property int|null $free_throws_made
 * @property int|null $rebounds
 * @property int|null $offensive_rebounds
 * @property int|null $defensive_rebounds
 * @property int|null $timeouts
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game|null $game
 * @property-read \App\Models\Player|null $player
 * @property-read \App\Models\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereAssists($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereDefensiveRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereFieldGoals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereFieldGoalsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereFlagrantFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereFreeThrows($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereFreeThrowsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereLosses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereOffensiveRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer wherePersonalFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreAgainst($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreDiff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP10($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP10Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP10Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP1Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP1Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP2Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP2Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP3Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP3Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP4Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP4Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP5Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP5Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP6($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP6Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP6Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP7($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP7Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP7Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP8($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP8Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP8Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP9($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP9Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereScoreP9Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereSteals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereTechnicalFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereThreePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereThreePointsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereTimeouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereTurnovers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereTwoPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereTwoPointsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GamePlayer whereWins($value)
 */
	class GamePlayer extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameTeam query()
 */
	class GameTeam extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $slug
 * @property string $name
 * @property string|null $body
 * @property string|null $position
 * @property string|null $birthday
 * @property string|null $status
 * @property string|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Official whereUpdatedAt($value)
 */
	class Official extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int|null $external_id
 * @property int|null $user_id
 * @property string|null $slug
 * @property string $title
 * @property string $body
 * @property string $status
 * @property array|null $data
 * @property int|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Page withoutTrashed()
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int|null $external_id
 * @property string|null $slug
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $nickname
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property string $status
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $name
 * @property-read mixed $number
 * @property-read mixed $position
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read mixed $stats
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Player withoutTrashed()
 */
	class Player extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $player_id
 * @property int $team_id
 * @property string|null $position
 * @property string|null $number
 * @property-read \App\Models\Player|null $player
 * @property-read \App\Models\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerTeam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerTeam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerTeam query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerTeam whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerTeam wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerTeam wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PlayerTeam whereTeamId($value)
 */
	class PlayerTeam extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int|null $external_id
 * @property int|null $user_id
 * @property int $is_pinned
 * @property string|null $slug
 * @property string $title
 * @property string $body
 * @property string $status
 * @property array|null $data
 * @property int|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post withoutTrashed()
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int|null $external_id
 * @property string|null $slug
 * @property string $name
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $birthday
 * @property string|null $status
 * @property array|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Game> $games
 * @property-read int|null $games_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Referee withoutTrashed()
 */
	class Referee extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int|null $external_id
 * @property string $event_id
 * @property string|null $slug
 * @property string $title
 * @property string|null $body
 * @property string $status
 * @property array|null $data
 * @property int|null $scheduled_at
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Event $event
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Game> $games
 * @property-read int|null $games_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Round withoutTrashed()
 */
	class Round extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $group
 * @property string $name
 * @property bool $locked
 * @property array $payload
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting wherePayload($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string|null $type
 * @property string|null $for
 * @property string|null $event_id
 * @property string|null $game_id
 * @property string|null $team_id
 * @property string|null $player_id
 * @property int $games
 * @property int|null $wins
 * @property int|null $losses
 * @property int|null $score
 * @property int|null $score_against
 * @property int|null $score_diff
 * @property int|null $score_p1
 * @property int|null $score_p1_against
 * @property int|null $score_p1_diff
 * @property int|null $score_p2
 * @property int|null $score_p2_against
 * @property int|null $score_p2_diff
 * @property int|null $score_p3
 * @property int|null $score_p3_against
 * @property int|null $score_p3_diff
 * @property int|null $score_p4
 * @property int|null $score_p4_against
 * @property int|null $score_p4_diff
 * @property int|null $score_p5
 * @property int|null $score_p5_against
 * @property int|null $score_p5_diff
 * @property int|null $score_p6
 * @property int|null $score_p6_against
 * @property int|null $score_p6_diff
 * @property int|null $score_p7
 * @property int|null $score_p7_against
 * @property int|null $score_p7_diff
 * @property int|null $score_p8
 * @property int|null $score_p8_against
 * @property int|null $score_p8_diff
 * @property int|null $score_p9
 * @property int|null $score_p9_against
 * @property int|null $score_p9_diff
 * @property int|null $score_p10
 * @property int|null $score_p10_against
 * @property int|null $score_p10_diff
 * @property int|null $assists
 * @property int|null $steals
 * @property int|null $blocks
 * @property int|null $turnovers
 * @property int|null $fouls
 * @property int|null $personal_fouls
 * @property int|null $technical_fouls
 * @property int|null $flagrant_fouls
 * @property int|null $three_points
 * @property int|null $three_points_made
 * @property int|null $two_points
 * @property int|null $two_points_made
 * @property int|null $field_goals
 * @property int|null $field_goals_made
 * @property int|null $free_throws
 * @property int|null $free_throws_made
 * @property int|null $rebounds
 * @property int|null $offensive_rebounds
 * @property int|null $defensive_rebounds
 * @property int|null $timeouts
 * @property float|null $score_avg
 * @property float|null $score_against_avg
 * @property float|null $score_diff_avg
 * @property float|null $assists_avg
 * @property float|null $steals_avg
 * @property float|null $blocks_avg
 * @property float|null $three_points_avg
 * @property float|null $three_points_percent
 * @property float|null $three_points_made_avg
 * @property float|null $two_points_avg
 * @property float|null $two_points_percent
 * @property float|null $two_points_made_avg
 * @property float|null $field_goals_percent
 * @property float|null $field_goals_avg
 * @property float|null $field_goals_made_avg
 * @property float|null $free_throws_avg
 * @property float|null $free_throws_percent
 * @property float|null $free_throws_made_avg
 * @property float|null $score_p1_avg
 * @property float|null $score_p1_against_avg
 * @property float|null $score_p1_diff_avg
 * @property float|null $score_p2_avg
 * @property float|null $score_p2_against_avg
 * @property float|null $score_p2_diff_avg
 * @property float|null $score_p3_avg
 * @property float|null $score_p3_against_avg
 * @property float|null $score_p3_diff_avg
 * @property float|null $score_p4_avg
 * @property float|null $score_p4_against_avg
 * @property float|null $score_p4_diff_avg
 * @property float|null $score_p5_avg
 * @property float|null $score_p5_against_avg
 * @property float|null $score_p5_diff_avg
 * @property float|null $score_p6_avg
 * @property float|null $score_p6_against_avg
 * @property float|null $score_p6_diff_avg
 * @property float|null $score_p7_avg
 * @property float|null $score_p7_against_avg
 * @property float|null $score_p7_diff_avg
 * @property float|null $score_p8_avg
 * @property float|null $score_p8_against_avg
 * @property float|null $score_p8_diff_avg
 * @property float|null $score_p9_avg
 * @property float|null $score_p9_against_avg
 * @property float|null $score_p9_diff_avg
 * @property float|null $score_p10_avg
 * @property float|null $score_p10_against_avg
 * @property float|null $score_p10_diff_avg
 * @property float|null $turnovers_avg
 * @property float|null $fouls_avg
 * @property float|null $personal_fouls_avg
 * @property float|null $technical_fouls_avg
 * @property float|null $flagrant_fouls_avg
 * @property float|null $rebounds_avg
 * @property float|null $offensive_rebounds_avg
 * @property float|null $defensive_rebounds_avg
 * @property float|null $efficiency
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Event|null $event
 * @property-read \App\Models\Game|null $game
 * @property-read \App\Models\Player|null $player
 * @property-read \App\Models\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereAssists($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereAssistsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereBlocks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereBlocksAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereDefensiveRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereDefensiveReboundsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereEfficiency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFieldGoals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFieldGoalsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFieldGoalsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFieldGoalsMadeAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFieldGoalsPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFlagrantFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFlagrantFoulsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFoulsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFreeThrows($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFreeThrowsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFreeThrowsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFreeThrowsMadeAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereFreeThrowsPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereGames($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereLosses($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereOffensiveRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereOffensiveReboundsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat wherePersonalFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat wherePersonalFoulsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat wherePlayerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereRebounds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereReboundsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreAgainst($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreAgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreDiff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreDiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP1($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP10($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP10Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP10AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP10Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP10Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP10DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP1Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP1AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP1Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP1Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP1DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP2Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP2AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP2Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP2Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP2DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP3($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP3Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP3AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP3Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP3Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP3DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP4($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP4Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP4AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP4Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP4Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP4DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP5($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP5Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP5AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP5Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP5Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP5DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP6($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP6Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP6AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP6Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP6Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP6DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP7($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP7Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP7AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP7Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP7Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP7DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP8($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP8Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP8AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP8Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP8Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP8DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP9($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP9Against($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP9AgainstAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP9Avg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP9Diff($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereScoreP9DiffAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereSteals($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereStealsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTechnicalFouls($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTechnicalFoulsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereThreePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereThreePointsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereThreePointsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereThreePointsMadeAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereThreePointsPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTimeouts($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTurnovers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTurnoversAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTwoPoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTwoPointsAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTwoPointsMade($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTwoPointsMadeAvg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereTwoPointsPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Stat whereWins($value)
 */
	class Stat extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int|null $external_id
 * @property string|null $slug
 * @property string $title
 * @property string|null $short_title
 * @property string|null $body
 * @property string $status
 * @property object|null $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Game> $awayGames
 * @property-read int|null $away_games_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Coach> $coaches
 * @property-read int|null $coaches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Game> $homeGames
 * @property-read int|null $home_games_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Player> $players
 * @property-read int|null $players_count
 * @property-read mixed $stats
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereShortTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team withoutTrashed()
 */
	class Team extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $data
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

