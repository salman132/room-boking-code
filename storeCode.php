<?php
//Room Booking with date and time
$checkData = MeetingRoomBooking::where('room_id', $room->room_no)->where('status', 1)->where('meeting_date', $meetingDate)->where(function ($dateQuery) use ($startTime, $endTime){

                    $dateQuery->where(function ($query) use ($startTime, $endTime) {$query->where(function ($q) use ($startTime, $endTime){
                        $q->where('start_time','>=',$startTime)->where('end_time','<=',$endTime); })
                        ->orWhere(function ($q) use ($startTime, $endTime){ $q->where('start_time','<',$startTime)->where('end_time','>',$startTime); });})

                        ->orwhere(function ($query) use ($startTime, $endTime) {$query->where(function ($q) use ($startTime, $endTime){ $q->where('start_time','>',$startTime)->where('end_time','<',$endTime); })
                            ->orWhere(function ($q) use ($startTime, $endTime){ $q->where('start_time','<',$endTime)->where('end_time','>',$endTime); });});
                });
                

// Find busy aganets between 2 dates


$assigned_agent = AssignAgentToProject::where(function ($dateQuery) use ($startTime, $endTime){

            $dateQuery->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime){
                $q->where('service_start','>=',$startTime)
                    ->where('service_ends','<=',$endTime); })
                ->orWhere(function ($q) use ($startTime, $endTime)
                { $q->where('service_start','<',$startTime)
                    ->where('service_ends','>',$startTime); });})
                    ->orwhere(function ($query) use ($startTime, $endTime)
                    {$query->where(function ($q) use ($startTime, $endTime)
                    { $q->where('service_start','>',$startTime)->where('service_ends','<',$endTime); })
                    ->orWhere(function ($q) use ($startTime, $endTime){ $q->where('service_start','<',$endTime)->where('service_ends','>',$endTime); });});
        })->get();



?>
