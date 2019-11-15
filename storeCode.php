   public function store(Request $request)
    {
        $request->validate([
            'room'=> 'required',
            'date'=> 'required|date',
            'stime'=> 'required',
            'etime'=> 'required',
            'description'=> 'required'
        ]);
        $booking = new Booking();
        $booking->user_id = Auth::id();
        $booking->room = $request->room;
        $booking->date = $request->date;
        $booking->stime = $request->stime;
        $time = Carbon::create($request->stime)->add($request->etime,'hour')->toTimeString();
        $booking->etime = $time;
        $booking->description = $request->description;
        $bookCheck = Booking::whereDate('date',$request->date)
            ->where('room',$request->room)->whereTime('stime','<=',$time)

            ->get();

        if(!empty($bookCheck)){

            foreach ($bookCheck as $b){
                dd($b->user_id);
            }
        }

        $booking->save();
        Session::flash('success','You booked a room');
        return redirect()->back();
    }
