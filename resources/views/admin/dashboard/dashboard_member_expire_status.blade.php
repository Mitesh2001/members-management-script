<div class="u-status color-{{ $status == 'danger' ? 'red': 'green' }}">
    {{ __('Membership') }}

    {{ $status == 'danger' ? __('Expired') : __('Expired').' at '.$member->validity_date }}
</div>
