<?php

namespace App\Http\Controllers;

use App\Models\Breeding;
use App\Models\Breeding_detail;
use App\Models\Commercial;
use App\Models\currEgg;
use App\Models\Hatchery;
use App\Models\Hatchery_detail;
use App\Models\Machine;
use App\Models\Pen;
use App\Services\countService;
use App\Services\moveService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class HatcheryController extends Controller
{
    protected $countService;
    protected $moveService;
    public function __construct(countService $countService, moveService $moveService)
    {
        $this->countService = $countService;
        $this->moveService = $moveService;
    }
    public function getegg($id)
    {
        // dd($id);
        // return $id;
        try {
            $breedings = Breeding::with('breedingDetails')
                ->whereHas('pen', function ($query) use ($id) {
                    $query->where('code_pen', 'like', $id . '%');
                })
                ->where('status', 'active')
                ->get();
            // return $breedings;
            // dd($breedings);

            $totalEggs = 0;

            // return $breedings->count();
            foreach ($breedings as $breeding) {
                $totalEggs += $breeding->breedingDetails->where('status', 'active')->sum('total_egg');
                // if($breeding->breedingDetails->where('status', 'active')->sum('total_egg')!=0){
                //     $breeding->breedingDetails()->where('status', 'active')->update(['status'=>'inactive']);
                // }
                // return  $breeding->breedingDetails->where('status', 'active')->sum('total_egg');
            }
            return $totalEggs;
        } catch (\Throwable $th) {
            return response()->json(['error' => 'pen data not found!'], 404);
        }
    }
    public function anotheregg($id)
    {
        // dd($id);
        // return 3;
        try {
            $curr = currEgg::where('id_pen', $id)->first();
            return $curr->qty ?? 0;
        } catch (\Throwable $th) {
            return response()->json(['error' => 'pen data not found!'], 404);
        }
    }
    public function userIndex()
    {
        $hatchery = Hatchery::with('hatcheryDetails')->where('status', 'active')->get()->toArray();

        return Inertia::render('user/Hatchery', compact('hatchery'));
    }
    public function adminIndex()
    {
        $hatchery = Hatchery::with('hatcheryDetails', 'machine', 'pen')->get()->toArray();

        return Inertia::render('admin/hatchery', compact('hatchery'));
    }

    public function createHatchery()
    {
        $pen = Pen::with('kandang')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'breeding');
            })
            ->whereHas('breeding', function ($query) {
                $query->where('status', 'active');
            })
            ->selectRaw('DISTINCT CAST(REGEXP_SUBSTR(code_pen, "^[0-9]+") AS UNSIGNED) AS indukan')
            ->get();
            // ->unique();
        $pen2 = currEgg::get();
        // dd($pen);

        $machine = Machine::where('status', 'active')->get();
        return Inertia::render('user/FormCreateHatchery', ['pen' => $pen, 'pen2' => $pen2, 'machine' => $machine]);
    }
    public function storeHatchery(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pen' => 'required|integer',
            // 'id_pen2' => 'nullable|integer',
            'another_pen' => 'nullable|integer',
            'id_machine' => 'required|integer',
            'total_setting' => 'required|integer',
            'inputBy' => 'required',
        ]);

        // dd($validator);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $request->validate([
            'id_pen' => 'required|integer',
            'another_pen' => 'nullable|integer',
            'id_machine' => 'required|integer',
            'inputBy' => 'required',
        ]);

        $input['setting_date'] = Carbon::now();

        $input2 = $request->validate([
            'total_setting' => 'required|integer',
            'inputBy' => 'required',
        ]);

        DB::beginTransaction();

        try {
            Machine::where('id', $input['id_machine'])->update([
                'status' => 'inactive',
            ]);
            // dd($validator['id_pen']);
            $id = $input['id_pen'];
            $breedings = Breeding::with('breedingDetails')
                ->whereHas('pen', function ($query) use ($id) {
                    $query->where('code_pen', 'like', $id . '%');
                })
                ->where('status', 'active')
                ->get();

            $cost = 0;

            foreach ($breedings as $breeding) {
                $cost += $breeding->breedingDetails()->where('status', 'active')->sum('cost_unit');
                $breeding
                    ->breedingDetails()
                    ->where('status', 'active')
                    ->update(['status' => 'inactive']);
            }

            if ($request->another_pen) {
                $curr = currEgg::where('id_pen', $request->another_pen)->first();
                $cost += $curr->cost_egg;
                $curr->delete();
            }
            $input['cost_total'] = $cost;

            $machine = Machine::where('id', $input['id_machine'])->first();
            if ($input2['total_setting'] > $machine->kapasitas) {
                $cost_egg = $cost / $input2['total_setting'];
                $input['cost_total'] = $cost_egg * $machine->kapasitas;
                $curr_egg = $input2['total_setting'] - $machine->kapasitas;
                $curr_cost = $curr_egg * $cost_egg;
                $input2['total_setting'] = $machine->kapasitas;
                currEgg::create([
                    'id_pen' => $input['id_pen'],
                    'qty' => $curr_egg,
                    'cost_egg' => $curr_cost,
                ]);
            }
            // dd($input);

            $hatchery = Hatchery::create($input);

            $input2['id_hatchery'] = $hatchery->id_hatchery;

            Hatchery_detail::create($input2);

            foreach ($breedings as $breeding) {
                $breeding
                    ->breedingDetails()
                    ->where('status', 'active')
                    ->update([
                        'status' => 'inactive',
                    ]);
            }
            // Breeding_detail::where('id_breeding', $breeding->id_breeding)
            //     ->where('status', 'active')
            //     ->update([
            //         'status' => 'inactive',
            //     ]);

            DB::commit();

            return redirect()->route('user.hatchery')->with('success', 'Berhasil membuat kandang Hatchery baru');
        } catch (\Exception $e) {
            DB::rollback();

            dd($e->getMessage());
            return back()->withErrors('error', 'Gagal membuat kandang Hatchery baru: ' . $e->getMessage());
        }
    }

    public function threeInputHatchery($id)
    {
        $hatcheryDetail = Hatchery_detail::where('id_hatchery', $id)->firstOrFail();
        return Inertia::render('user/FormThreeHatchery', ['hatcheryDetail' => $hatcheryDetail]);
    }

    public function threeInputedHatchery(Request $request)
    {
        $input = $request->validate([
            'id_hatchery' => 'required',
            'infertile' => 'required',
            'explode' => 'required',
            'hatcher' => 'required',
        ]);

        $hatcheryDetail = Hatchery_detail::with('hatchery')->where('id_hatchery', $input['id_hatchery'])->firstOrFail();
        $hatcheryDetail->update([
            'infertile' => $input['infertile'],
            'explode' => $input['explode'],
            'hatcher' => $input['hatcher'],
        ]);

        return redirect()->route('user.hatchery')->with('success', 'berhasil membuat kandang Breeding baru');
    }
    public function eightynInputHatchery($id)
    {
        $hatcheryDetail = Hatchery_detail::where('id_hatchery', $id)->firstOrFail();
        return Inertia::render('user/FormEightynHatchery', ['hatcheryDetail' => $hatcheryDetail]);
    }

    public function eightynInputedHatchery(Request $request)
    {
        $input = $request->validate([
            'id_hatchery' => 'required',
            'infertile' => 'required',
            'explode' => 'required',
            'hatcher' => 'required',
        ]);

        $hatcheryDetail = Hatchery_detail::with('hatchery')->where('id_hatchery', $input['id_hatchery'])->firstOrFail();
        $hatcheryDetail->update([
            'infertile' => $input['infertile'],
            'explode' => $input['explode'],
            'hatcher' => $input['hatcher'],
        ]);
        $hatchery = Hatchery::where('id_hatchery', $input['id_hatchery'])->firstOrFail();
        $hatchery->update([
            'candling_date' => Carbon::now(),
        ]);

        return redirect()->route('user.hatchery')->with('success', 'berhasil membuat kandang Breeding baru');
    }
    public function finalInputHatchery($id)
    {
        $hatcheryDetail = Hatchery_detail::where('id_hatchery', $id)->firstOrFail();
        return Inertia::render('user/FormTwentyoneHatchery', ['hatcheryDetail' => $hatcheryDetail]);
    }

    public function finalInputedHatchery(Request $request)
    {
        $input = $request->validate([
            'id_hatchery' => 'required',
            'dead_in_egg' => 'required',
            'hatchability' => 'required',
            'doc_afkir' => 'required',
            'saleable' => 'required',
        ]);

        $hatcheryDetail = Hatchery_detail::where('id_hatchery', $input['id_hatchery'])->firstOrFail();

        $hatchery = Hatchery::where('id_hatchery', $input['id_hatchery'])->firstOrFail();

        $hatchery->update([
            'pull_chicken_date' => Carbon::now(),
        ]);
        $hatcheryDetail->update([
            'dead_in_egg' => $input['dead_in_egg'],
            'hatchability' => $input['hatchability'],
            'doc_afkir' => $input['doc_afkir'],
            'saleable' => $input['saleable'],
        ]);

        return redirect()->route('user.hatchery')->with('success', 'berhasil membuat kandang Breeding baru');
    }

    public function move($id)
    {
        // dd('test');
        $pen = Pen::with('kandang')
            ->whereHas('kandang', function ($query) {
                $query->where('jenis_kandang', 'commerce');
            })
            // ->whereHas('commercial', function ($query) {
            //     $query->where('status', 'active');
            // })
            ->get();
        $hatchery = Hatchery::with('hatcheryDetails')->find($id);
        // dd($hatchery->hatcheryDetails[0]->saleable);

        return Inertia::render('user/moveHatchery', ['pen' => $pen, 'hatchery' => $hatchery, 'id' => $id]);
    }

    public function moved(Request $request, $id)
    {
        // dd($id);
        $input = $request->validate([
            'id_pen' => 'required',
            'entryDate' => 'required|date',
            'entry_population' => 'required|integer',
            'age' => 'required|integer',
            'inputBy' => 'required',
        ]);
        // dd($request);
        try {
            DB::beginTransaction();
            $hatchery = Hatchery::with('hatcheryDetails')->find($id);
            // $input['entry_population'] = $hatchery->hatcheryDetails[0]->saleable;
            $check = Commercial::with('commercialDetails')->where('id_pen', $input['id_pen'])->first();

            if (isset($check)) {
                // dd('test1');
                // $check2 = Commercial::with(['commercialDetails' => function($query) {
                //     // Filter hanya yang memiliki created_at hari ini
                //     $query->whereDate('created_at', Carbon::today());
                // }])->where('id_pen', $input['id_pen'])->first();
                // if(isset($check2)){
                //     $this->moveService->createMoveTable(0, $input['id_pen'], $input['entry_population'], 0, $hatchery->cost_total, 0, 'active');
                // }else{
                //     $this->moveService->moveToCommercial($check2,0,0,0,0,$hatchery->cost_total);
                // }
                $this->moveService->moveTable($input['id_pen'], 0, $hatchery->cost_total, $input['entry_population'], 0, $input['entry_population'], 0);
            } else {
                $this->moveService->createMoveTable(0, $input['id_pen'], $input['entry_population'], 0, $hatchery->cost_total ?? 0, 0, 'inactive');
                $input['age'] = 0;
                $input['last_population'] = $input['entry_population'];
                $input['total_cost'] = $hatchery->cost_total ?? 0;
                $input['unit_cost'] = $hatchery->cost_total ?? 0;
                // dd( $input);
                Commercial::create($input);
            }
            $hatchery->update([
                'status' => 'inactive',
            ]);
            Machine::where('id', $hatchery->id_machine)->update([
                'status' => 'active',
            ]);
            DB::commit();
            return redirect()->route('user.hatchery')->with('success', 'Berhasil memindahkan kandang ke Pen Commercial');
        } catch (\Throwable $th) {
            DB::rollback();
            dd('test');
            return redirect()
                ->route('user.hatchery')
                ->withErrors('error', 'Gagal memindahkan kandang: ' . $th->getMessage());
        }
    }
}
