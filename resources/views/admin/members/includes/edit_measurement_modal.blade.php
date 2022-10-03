<div class="modal" tabindex="-1" role="dialog" id="measurement-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="btn btn-light btn-sm mr-2 d-none" id="back-arrow" onclick="backToMeasurementList()">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                </button>

                <h5 class="modal-title">
                    {{ __('Measurement Update') }}
                </h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <table class="user-detail-list col-12 measurement-table">
                    <thead>
                        <tr>
                            <th class="ptb-15">
                                <div class="user-title">#</div>
                            </th>

                            <th class="ptb-15">
                                <div class="user-title">{{ __('Measurement Date') }}</div>
                            </th>

                            <th class="ptb-15">
                                <div class="user-title">{{ __('Measurement Value') }}</div>
                            </th>

                            <th class="ptb-15">
                                <div class="user-title">{{ __('Action') }}</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div class="measurement-form-edit">
                    <div class="col-12">
                        <ul class="alert alert-danger d-none" id="measurement-edit-error"></ul>
                    </div>

                    <form role="form" name="measurement-form-edit">
                        @csrf
                        <input type="hidden" name="id">
                        <input type="hidden" name="member_id">

                        <div class="form-input col-12">
                            <label>
                                {{ __('Measurement Date') }}
                                <input name="measurement_date"
                                    tabindex="1"
                                    class="measurement-date"
                                    type="text"
                                    placeholder="@lang('Measurement Date')"
                                    value="{{ old('measurement_date', $member->measurement_date) }}"
                                    required
                                />
                            </label>
                        </div>

                        <div class="form-input col-12">
                            <label>
                                {{ __('Measurement Type') }}
                                <select class="selectpicker btn-primary"
                                    name="measurement_type"
                                    id="measurement-type"
                                    data-title="Location"
                                    id="state_list2"
                                    data-width="100%"
                                    required
                                >
                                    <option selected disabled value="">
                                        @lang('Select Measurement Type')
                                    </option>

                                    @foreach ($measurementTypes as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>

                        <div class="form-input col-12">
                            <label>
                                {{ __('Measurement Value') }}
                                <input name="measurement_value"
                                    tabindex="1"
                                    id="measurement-value"
                                    type="number"
                                    placeholder="{{ __('Measurement Value') }}"
                                    value="{{ old('measurement_value', $member->measurement_value) }}"
                                    required
                                />
                            </label>
                        </div>

                        <div class="form-group col-12">
                            <button type="reset" class="nav-btn bg-red color-red mr-3">
                                {{ __('Reset') }}
                            </button>

                            <button type="submit" class="nav-btn bg-blue color-blue update-measurement">
                                {{ __('Submit') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
