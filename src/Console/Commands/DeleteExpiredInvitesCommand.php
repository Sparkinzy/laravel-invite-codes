<?php

namespace Junges\InviteCodes\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Junges\InviteCodes\Events\DeletedExpiredInvitesEvent;

class DeleteExpiredInvitesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invite-codes:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete all expired invites from your database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $model = app(config('invite-codes.models.invite_model'));

        $model->where('expires_at', '<=', Carbon::now(config('app.timezone')))->delete();

        $this->info('Delete all expired invites.');

        event(new DeletedExpiredInvitesEvent());

        return true;
    }
}
