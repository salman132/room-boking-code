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
                { $q->where('service_start','<=',$startTime)
                    ->where('service_ends','>=',$startTime); });})
                    ->orwhere(function ($query) use ($startTime, $endTime)
                    {$query->where(function ($q) use ($startTime, $endTime)
                    { $q->where('service_start','>',$startTime)->where('service_ends','<',$endTime); })
                    ->orWhere(function ($q) use ($startTime, $endTime){ $q->where('service_start','<=',$endTime)->where('service_ends','>',$endTime); });});
        })->get();




?>

<script>
  
   $('#datepicker').focusout(function () {
            var start_date =  $(this).val();
            var end_date = $("#datepicker2").val();


            if(start_date != '{{$assign->service_start}}'){
                $('#selected-agent').hide();
                $("#mycheck").prop("checked", false);
            }
            if(start_date == '{{$assign->service_start}}'){
                $('#selected-agent').show();
                $("#mycheck").prop("checked", true);
            }

            $.ajax({
                type: "GET",
                url: "{{ url('eroster/agent-finder/edit') }}/" + start_date,
                data:{
                    end_date : end_date,
                },

                success:function (response) {
                    $("#agentArea").html("");
                    $("#agentArea").append(response);
                    console.log(response)

                },
                error: function (xhr) {
                    console.log(xhr)
                }
            })




        });
  
</script>
