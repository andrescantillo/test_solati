<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
  use HasFactory;

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'log_activities';

  protected $fillable = [
    'subject', 'success', 'endpoint', 'method', 'url', 'values', 'message', 'ip', 'agent', 'user_id'
  ];

  public static function getAllLogsByDateAndUser($request)
  {
    return LogActivity::whereBetween(
      'created_at',
      [date("Y-m-d 00:00:00", strtotime($request->start_date)), date("Y-m-d 23:59:59", strtotime($request->start_date))]
    )->get();
  }
}
