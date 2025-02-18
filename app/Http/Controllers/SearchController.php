<?php

namespace App\Http\Controllers;

use App\Models\Histories;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function searchUser(Request $request)
    {
        $search = $request->input('search');
        $users = User::where('name', 'like', "%$search%")->get();
        return view('admin.users', compact('users'));
    }

    public function searchHistory(Request $request)
    {
        $search = $request->input('query');
        $month = $request->input('date'); // Expected format: YYYY-MM

        $users = User::select('id', 'firstname', 'middlename', 'lastname', 'email')
            ->where('firstname', 'like', "%$search%")
            ->orWhere('lastname', 'like', "%$search%")
            ->orWhere('middlename', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->get();

        $records = collect();

        if ($users->isNotEmpty()) {
            $userIds = $users->pluck('id');
            $historiesQuery = Histories::whereIn('user_id', $userIds);

            if ($month) {
                $historiesQuery->where('datetime', 'like', "$month%");
            }

            $histories = $historiesQuery->orderBy('datetime', 'desc')->get();

            foreach ($histories as $history) {
                $user = $users->firstWhere('id', $history->user_id);
                $records->push([
                    'user' => $user,
                    'history' => $history,
                ]);
            }
        }

        // Search in histories description
        $historiesFromDescription = Histories::where('description', 'like', "%$search%");

        if ($month) {
            $historiesFromDescription->where('datetime', 'like', "$month%");
        }

        $historiesFromDescription = $historiesFromDescription->orderBy('datetime', 'desc')->get();

        foreach ($historiesFromDescription as $history) {
            $user = User::find($history->user_id);
            $exists = $records->contains(fn($record) => $record['history']->id === $history->id);

            if (!$exists) {
                $records->push([
                    'user' => $user,
                    'history' => $history,
                ]);
            }
        }

        // Search in histories datetime
        $historiesFromDatetime = Histories::where('datetime', 'like', "%$search%");

        if ($month) {
            $historiesFromDatetime->where('datetime', 'like', "$month%");
        }

        $historiesFromDatetime = $historiesFromDatetime->orderBy('datetime', 'desc')->get();

        foreach ($historiesFromDatetime as $history) {
            $user = User::find($history->user_id);
            $exists = $records->contains(fn($record) => $record['history']->id === $history->id);

            if (!$exists) {
                $records->push([
                    'user' => $user,
                    'history' => $history,
                ]);
            }
        }

        // Final sort of all records by datetime before pagination
        $records = $records->sortByDesc(function ($record) {
            return $record['history']->datetime;
        });

        // Paginate results
        $perPage = 9;
        $currentPage = request()->get('page', 1);
        $paginatedRecords = $records->slice(($currentPage - 1) * $perPage, $perPage)->values();

        return response()->json([
            'success' => true,
            'records' => $paginatedRecords,
            'total' => $records->count(),
            'perPage' => $perPage,
            'currentPage' => (int) $currentPage,
        ]);
    }
}