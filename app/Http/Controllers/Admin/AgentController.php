<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        return $this->success('Agent account has been created!', [
            'agents' => Agent::paginate(15)
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required',
            'email' => 'required|email|unique:agents,email',
            'password' => 'required'
        ]);

        Agent::create($validated);

        return $this->success('Agent account has been created!');
    }

    public function enable(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required'
        ]);

        $agent = Agent::find($validated['id']);

        if(!$agent)
        return $this->notFound('Agent not found!');

        $agent->status = \App\Enums\Status::ACTIVE->value;
        $agent->save();

        return $this->success('Agent has been enabled!');
    }

    public function disable(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required'
        ]);

        $agent = Agent::find($validated['id']);

        if(!$agent)
        return $this->notFound('Agent not found!');

        $agent->status = \App\Enums\Status::DISABLED->value;
        $agent->save();

        return $this->success('Agent has been disabled!');
    }
}
