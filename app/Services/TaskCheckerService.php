<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Ticket;

class TaskCheckerService
{
    public function check(Ticket $ticket): void
    {
        $ticket->load(['user.task', 'passanger', 'seats', 'wagon']);

        $task = $ticket->user?->task;

        if (!$task || $task->status !== 'pending') {
            return;
        }

        $correct = $task->correct_answers;

        $wagonClass = $ticket->wagon->service_class instanceof \App\Enums\WagonServiceClassEnum
            ? $ticket->wagon->service_class->value
            : $ticket->wagon->service_class;

        $userAnswers = [
            'from_station_id' => (int) $ticket->from,
            'to_station_id' => (int) $ticket->to,

            'wagon_id' => $ticket->wagon_id,
            'wagon_class' => $wagonClass,

            'seats' => $ticket->seats
                ->pluck('number')
                ->map(fn($s) => (int) $s)
                ->sort()
                ->values()
                ->toArray(),

            'passanger' => [
                'surname' => $ticket->passanger->surname,
                'name' => $ticket->passanger->name,
                'patronymic' => $ticket->passanger->patronymic,
            ],

            'document' => [
                'type' => $ticket->passanger->document,
                'series' => (string) $ticket->passanger->series,
                'number' => (string) $ticket->passanger->number,
            ],
        ];

        $isCorrect = $this->compare($correct, $userAnswers);

        $task->update([
            'user_answers' => $userAnswers,
            'ticket_id' => $ticket->id,
            'is_answer_correct' => $isCorrect,
            'status' => $isCorrect ? 'passed' : 'failed',
        ]);
    }

    private function compare(array $correct, array $user): bool
    {
        return
            (int)$correct['from_station_id'] === (int)$user['from_station_id']
            && (int)$correct['to_station_id'] === (int)$user['to_station_id']

            && ($correct['wagon_class'] ?? null) === ($user['wagon_class'] ?? null)

            && collect($correct['seats'])->sort()->values()->toArray()
            === collect($user['seats'])->sort()->values()->toArray()

            && strtolower($correct['passanger']['surname'] ?? '') === strtolower($user['passanger']['surname'] ?? '')
            && strtolower($correct['passanger']['name'] ?? '') === strtolower($user['passanger']['name'] ?? '')
            && strtolower($correct['passanger']['patronymic'] ?? '') === strtolower($user['passanger']['patronymic'] ?? '')

            && ($correct['document']['type'] ?? null) === ($user['document']['type'] ?? null)
            && (string)($correct['document']['series'] ?? '') === (string)($user['document']['series'] ?? '')
            && (string)($correct['document']['number'] ?? '') === (string)($user['document']['number'] ?? '');
    }
}
