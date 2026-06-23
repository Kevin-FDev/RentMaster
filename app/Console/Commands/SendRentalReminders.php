<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Rental;
use App\Mail\RentalDueReminderNotification;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendRentalReminders extends Command
{
    // Alterado para bater exatamente com o comando que você está chamando!
    protected $signature = 'rentals:send-reminders';

    protected $description = 'Envia e-mails de alerta para usuários com aluguéis vencendo em 2 dias';

    public function handle()
    {
        // Pega a data de daqui a exatamente 2 dias (Com base em 22/06/2026, buscará 24/06/2026)
        $targetDate = Carbon::now()->addDays(2)->toDateString();

        // Busca aluguéis ativos que vencem nessa data específica
        $rentals = Rental::where('end_date', $targetDate)
                         ->where('status', 'ativo')
                         ->with(['user', 'product'])
                         ->get();

        if ($rentals->isEmpty()) {
            $this->info('Nenhum aluguel vencendo em 2 dias encontrado.');
            return;
        }

        foreach ($rentals as $rental) {
            if ($rental->user && $rental->product) {
                Mail::to($rental->user->email)->send(new RentalDueReminderNotification(
                    $rental->product->name,
                    $rental->end_date
                ));
            }
        }

        $this->info('Lembretes de e-mail enviados com sucesso para ' . $rentals->count() . ' usuários.');
    }
}
