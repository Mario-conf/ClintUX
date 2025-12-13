<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::with('user')->latest()->paginate(20);
        return view('admin.audits.index', compact('audits'));
    }
}
