<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $tickets = Ticket::paginate();

        return view('ticket.index', compact('tickets'))
            ->with('i', ($request->input('page', 1) - 1) * $tickets->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $ticket = new Ticket();

        return view('ticket.create', compact('ticket'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TicketRequest $request): RedirectResponse
    {
        Ticket::create($request->validated());

        return Redirect::route('tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $ticket = Ticket::find($id);

        return view('ticket.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $ticket = Ticket::find($id);

        return view('ticket.edit', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $ticket->update($request->validated());

        return Redirect::route('tickets.index')
            ->with('success', 'Ticket updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Ticket::find($id)->delete();

        return Redirect::route('tickets.index')
            ->with('success', 'Ticket deleted successfully');
    }
}
