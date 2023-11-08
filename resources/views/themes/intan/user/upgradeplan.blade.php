<form id="upform" style="margin-bottom: 0px; margin-top: 0px; padding-top: 0px; background:none; box-shadow:none;" action="{{route('user.upgrade-plan-store')}}"  autocomplete="off" method="post">
    @csrf
    <input type="hidden" value="{{ $invest->id }}" id="invest_id" name="invest_id" >
    <input type="hidden" value="{{ $invest->amount }}" id="invest_amount" name="invest_amount" >
   
        <div class="form-group col-md-10">
            <label>Tingkatkan Perangkat</label>
            <select name="plan_id" id="plan_id" required class="form-control">
                <option selected disabled value="">Pilih perangkat</option>
                @foreach ($managePlans as $item)
                    <option value="{{ $item->id }}" @if($plan->fixed_amount >= $item->fixed_amount) disabled @endif>{{ $item->name }}<small> ({{$item->fixed_amount}})</small></option>
                @endforeach
            </select>
        </div>
</form>