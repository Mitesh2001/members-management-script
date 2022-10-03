<ul class="member-list row">
    @foreach ($measurementTypes as $key => $value)
        @if ($memberMeasurements[$key]->first())
            <li class="col-12 col-lg-6" id="measurement-container-{{ $key }}">
                <div class="member-card">
                    <div class="monitoring-graph">
                        <div class="content-box chart-box">
                            <div class="head mb-3">
                                {{ $value }}
                                <div class="pull-right">
                                    <i class="fa fa-pencil" onclick="listMeasurements('{{ $key }}');"></i>
                                </div>
                            </div>

                            <canvas id="measurement-charts-{{ $key }}" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </li>
        @endif
    @endforeach
</ul>
