<!-- Button trigger modal -->
{{--<button type="button" class="btn btn-sm btn-primary" title="Edit History" data-toggle="modal" data-target="#edit_history_long_modal">
    <i class="fa fa-history"></i>
</button>--}}

<!-- Modal -->
{{--
<div class="modal fade" id="edit_history_long_modal" tabindex="-1" role="dialog" aria-labelledby="Edit History" aria-hidden="true">
    <div class="modal-dialog modal-lg text-left" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Edit History">Edit History</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    @forelse($model as $key => $activity_log)
                        <div class="card">
                        <div class="card-header">
                            <table class="table table-hover table-bordered">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th colspan="4" class="text-center">{{ 'Edit '.($key+1) }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-left">Date</th>
                                        <td>{{ \Carbon\Carbon::parse($activity_log->created_at)->format('d-m-Y h:i A') }}</td>
                                        <th class="text-left">User Type</th>
                                        <td>{{ $activity_log->causer ? @$activity_log->causer->getRoleNames()->first() : '' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-left">Username</th>
                                        <td>{{ $activity_log->causer ? @$activity_log->causer->name : '' }}</td>
                                        <th class="text-left">Module</th>
                                        <td>{{ $activity_log->log_name }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered" id="" style="width:100%;">
                                <thead class="bg-info">
                                    <tr>
                                        <th style="width: 10px;">#</th>
                                        <th>Field Name</th>
                                        @if($activity_log->description == 'created')
                                            <th>New Value</th>
                                        @elseif($activity_log->description == 'updated')
                                            <th>Old Value</th>
                                            <th>New Value</th>
                                        @elseif($activity_log->description == 'deleted')
                                            <th>Value</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$activity_log->changes['attributes'])
                                        @foreach($activity_log->changes['attributes'] as $key => $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $key }}</td>
                                                @if($activity_log->description == 'created')
                                                    <td>{{ $activity_log->changes['attributes'][$key] }}</td>
                                                @elseif($activity_log->description == 'updated')
                                                    <td>
                                                        @if(isset($activity_log->changes['old']))
                                                            {{ $activity_log->changes['old'][$key] }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $activity_log->changes['attributes'][$key] }}</td>

                                                @elseif($activity_log->description == 'deleted')
                                                    <td>{{ $activity_log->changes['attributes'][$key] }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @empty
                        {{ 'No History Available.' }}
                    @endforelse
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>--}}


{{--<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
</button>--}}


<!-- Modal -->
<div class="modal fade" id="edit_history{{ $id }}" tabindex="-1" aria-labelledby="edit_history_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_history_label">Edit History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @forelse($model as $key => $activity_log)
                    <div class="card">
                        <div class="card-header">
                            <table class="table table-hover table-bordered">
                                <thead class="bg-dark text-white">
                                <tr>
                                    <th colspan="4" class="text-center">{{ 'Edit '.($key+1) }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th class="text-left">Date</th>
                                    <td>{{ \Carbon\Carbon::parse($activity_log->created_at)->format('d-m-Y h:i A') }}</td>
                                    <th class="text-left">User Type</th>
                                    <td>{{ $activity_log->causer->role->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th class="text-left">Username</th>
                                    <td>{{ $activity_log->causer ? @$activity_log->causer->name : '' }}</td>
                                    <th class="text-left">Module</th>
                                    <td>{{ $activity_log->log_name }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover table-bordered" id="" style="width:100%;">
                                <thead class="bg-info">
                                <tr>
                                    <th style="width: 10px;">#</th>
                                    <th>Field Name</th>
                                    <th>Old Value</th>
                                    <th>New Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(@$activity_log->changes['attributes'])
                                    @foreach($activity_log->changes['attributes'] as $key => $value)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $key }}</td>
                                            <td>
                                                @if(isset($activity_log->changes['old']))
                                                    {{ $activity_log->changes['old'][$key] }}
                                                @endif
                                            </td>
                                            <td>{{ $activity_log->changes['attributes'][$key] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    {{ 'No History Available.' }}
                @endforelse
            </div>
        </div>
    </div>
</div>



