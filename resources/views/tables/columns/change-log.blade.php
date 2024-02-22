<div class="text-xs">
    <div class="py-2 grid" style="grid-template-columns: 1fr repeat(2, 200px); gap: 0px 10px;">
        <div class="font-bold" style="min-width: 100px;">{{ __('Field') }}</div>
        <div class="font-bold">{{ __('models.historical.prev_state') }}</div>
        <div class="font-bold">{{ __('models.historical.new_state') }}</div>
        @foreach ($getState() as $change)
            <div class="font-bold" style="min-width: 100px;">{{ __($change['field_trans_key']) }}</div>
            <div class="" style="overflow: hidden; text-overflow: ellipsis;">{{ $change['prev'] }}</div>
            <div class="" style="overflow: hidden; text-overflow: ellipsis;">{{ $change['new'] }}</div>
        @endforeach
    </div>
</div>
