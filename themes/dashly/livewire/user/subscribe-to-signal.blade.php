<div>
    @if ($hasSubscribe)
        <div class="row">
            <div class="col-12 text-center">
                <i class="fas fa-check-circle fa-4x text-success"></i>
                <div>
                    <div class="input-group my-2">
                        <input type="text" class="form-control" wire:model='inviteLink' readonly>
                    </div>
                    <small>
                        Copy and use your invite link. You can only used your invite link once and will not be
                        available again once this pages refreshes.
                    </small>
                </div>
            </div>
        </div>
    @else
        <form wire:submit.prevent='subscribe'>
            <div class="mb-3">
                <label for="">Choose Duration</label>
                <select class="form-control" wire:model='duration' wire:change='calculate'>
                    <option value="Choose">Choose Duration</option>
                    <option value="Monthly">Monthly</option>
                    <option value="Quarterly">Quarterly</option>
                    <option value="Yearly">Yearly</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="">Amount ({{ $settings->currency }})</label>
                <input type="number" wire:model='amount' class="form-control" id="" readonly>
                <small>Amount will be deducted from your account balance.</small>
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </div>
        </form>
    @endif
</div>
