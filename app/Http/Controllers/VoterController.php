<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voter;
use Illuminate\Support\Facades\Mail;
use App\Mail\VoterRegistered;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class VoterController extends Controller
{

    public function index(Request $request)
    {
        $query = Voter::query();

        if ($request->has('state') && $request->state != '') {
            $query->where('state', $request->state);
        }

        if (
            $request->has('district') && $request->district != ''
        ) {
            $query->where('district', $request->district);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->search . '%');
            });
        }

        $voters = $query->paginate(10);

        $states = Voter::select('state')->distinct()->pluck('state');
        $districts = Voter::select('district')->distinct()->pluck('district');

        return view('voters.index', compact('voters', 'states', 'districts'));
    }


    public function create()
    {
        $states = Voter::select('state')->distinct()->pluck('state');
        $districts = Voter::select('district')->distinct()->pluck('district');
        $taluks = Voter::select('taluk')->distinct()->pluck('taluk');
        return view('voters.create', compact('taluks', 'states', 'districts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date|before:' . now()->subYears(18)->format('Y-m-d'),
            'mobile' => 'required|unique:voters,mobile',
            'email' => 'required|email|unique:voters,email',
            'address' => 'required',
            'taluk' => 'required',
            'district' => 'required',
            'state' => 'required',
        ]);

        try {
            $voter = Voter::create($request->all());

            Mail::to($voter->email)->send(new VoterRegistered($voter));

            return redirect()->route('voters.index')->with('success', 'Voter registered successfully.');
        } catch (\Exception $e) {
            Log::error('Error while registering voter: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function show(Voter $voter)
    {
        return view('voters.show', compact('voter'));
    }


    public function destroy(Voter $voter)
    {
        $voter->delete();
        return redirect()->route('voters.index')->with('success', 'Voter deleted successfully.');
    }


    public function exportCsv()
    {
        $fileName = 'voters_list.csv';

        $voters = Voter::all();
        $headers = [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($voters) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['ID', 'First Name', 'Last Name', 'Mobile', 'Email', 'State', 'District']);

            foreach ($voters as $voter) {
                fputcsv($file, [
                    $voter->id,
                    $voter->first_name,
                    $voter->last_name,
                    $voter->mobile,
                    $voter->email,
                    $voter->state,
                    $voter->district
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

}
