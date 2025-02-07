@extends('mysqlinfo::layouts.app')

@section('mysqlinfo::content')

@if (isset($errors) && $errors->any())
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="alert alert-danger text-center shadow-lg p-4 rounded" style="max-width: 600px;">
            <h4 class="fw-bold"><i class="bi bi-exclamation-triangle-fill"></i> Error</h4>
            <ul class="list-unstyled mt-3">
                @foreach ($errors->all() as $error)
                    <li class="text-danger" style="font-size: 25px">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

@if(isset($dbinfo))
    <div class="container mt-5 main-container">
        <h1 class="text-center">Mysql Information</h1> 
        <div class="row mt-5">    
            <div class="col-md-2">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <h4 class="card-title">{{isset($dbinfo['database_connection']) ? ucfirst($dbinfo['database_connection']) : ''}}</h4>
                    <p class="card-text">Database Connection</p>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-01">
                    <div class="card-body" title="{{ $dbinfo['database_version'] }}">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <h4 class="card-title">
                        {{ isset($dbinfo['database_version']) ? explode('-', $dbinfo['database_version'])[0] : '' }}
                    </h4>
                    <p class="card-text">Database Version</p>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <h4 class="card-title">{{isset($dbinfo['database_name']) ? $dbinfo['database_name'] : ''}}</h4>
                    <p class="card-text">Database Name</p>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <h4 class="card-title">{{isset($dbinfo['database_host']) ? $dbinfo['database_host'] : ''}}</h4>
                    <p class="card-text">Database Host</p>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <h4 class="card-title">{{isset($dbinfo['database_characterset']) ? $dbinfo['database_characterset']->charset : ''}}</h4>
                    <p class="card-text">Characterset</p>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <h4 class="card-title">{{isset($dbinfo['protocol_version']) ? $dbinfo['protocol_version'] : ''}}</h4>
                    <p class="card-text">Protocol Version</p>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <h4 class="card-title">{{isset($dbinfo['collation']) ? $dbinfo['collation'] : ''}}</h4>
                    <p class="card-text">Database Collation</p>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <h4 class="card-title">{{isset($dbinfo['size']) ? $dbinfo['size']['MB'].' MB ('.$dbinfo['size']['GB'].' GB)' : '' }}</h4>
                    <p class="card-text">Database Size</p>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <h4 class="card-title">{{isset($dbinfo['engine']) ? $dbinfo['engine'] : '' }}</h4>
                    <p class="card-text">Database Engine</p>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <span class="card-text">Total Tables: <strong>{{isset($dbinfo['stats']) ? $dbinfo['stats']->table_count : '' }}</strong></span></br>
                    <span class="card-text">Total Rows: <strong>{{isset($dbinfo['stats']) ? $dbinfo['stats']->row_count : '' }}</strong></span></br>
                    <span class="card-text">Total Data: <strong>{{isset($dbinfo['stats']) ? $dbinfo['stats']->data_size : '' }}MB</strong></span>

                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-01">
                    <div class="card-body">
                    <span class="badge-box"><i class="fa fa-database"></i></span>
                    <span class="card-text">Index Size: <strong>{{isset($dbinfo['stats']) ? $dbinfo['stats']->index_size : '' }}MB</strong></span></br>
                    <span class="card-text">Overhead: <strong>{{isset($dbinfo['stats']) ? $dbinfo['stats']->overhead : '' }}</strong></span></br>
                    {{-- <a href="#" class="btn btn-default text-uppercase">Explore</a> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex mb-3">
            {{-- <div class="col-md-3 flex-fill">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">{{isset($dbinfo['database_connection']) ? ucfirst($dbinfo['database_connection']) : 'Database'}} Core Information</div>
                    </div>
                    <div class="card-body">
                        <div class="card-text table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Database Connection</td>
                                        <td>{{isset($dbinfo['database_connection']) ? $dbinfo['database_connection'] : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>Database version</td>
                                        <td>{{isset($dbinfo['database_version']) ? $dbinfo['database_version'] : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>Database Name</td>
                                        <td>{{isset($dbinfo['database_name']) ? $dbinfo['database_name'] : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>Database Host</td>
                                        <td>{{isset($dbinfo['database_host']) ? $dbinfo['database_host'] : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>Database Charset</td>
                                        <td>{{isset($dbinfo['database_characterset']) ? $dbinfo['database_characterset']->charset : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>Protocol Version</td>
                                        <td>{{isset($dbinfo['protocol_version']) ? $dbinfo['protocol_version'] : ''}}</td>
                                    </tr>
                                    <tr>
                                        <td>Database Collation</td>
                                        <td>{{isset($dbinfo['collation']) ? $dbinfo['collation'] : ''}}</td>
                                    </tr>

                                    <tr>
                                        <td>Database Size</td>
                                        <td>{{isset($dbinfo['size']) ? $dbinfo['size']['MB'].' MB ('.$dbinfo['size']['GB'].' GB)' : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Database Engine</td>
                                        <td>{{isset($dbinfo['engine']) ? $dbinfo['engine'] : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Database Total Tables</td>
                                        <td>{{isset($dbinfo['stats']) ? $dbinfo['stats']->table_count : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Database Total Row Count</td>
                                        <td>{{isset($dbinfo['stats']) ? $dbinfo['stats']->row_count : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Data Size</td>
                                        <td>{{isset($dbinfo['stats']) ? $dbinfo['stats']->data_size : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Index Size</td>
                                        <td>{{isset($dbinfo['stats']) ? $dbinfo['stats']->index_size : '' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Data Overhead</td>
                                        <td>{{isset($dbinfo['stats']) ? $dbinfo['stats']->overhead : '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-md-6 flex-fill">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title">Database Tables</div>
                        <div>
                            <input type="text" name="search_tables" id="search_tables" class="form-control form-control-sm" placeholder="Search"/>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-text table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Total Rows</th>
                                        <th scope="col">Data Size (MB)</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Collation</th>
                                        <th scope="col">Total Triggers</th>
                                        <th scope="col">Total Indexes</th>
                                        <th scope="col">Total Index Size</th>
                                        <th scope="col">Total Procedures</th>
                                        <th scope="col">Total Table Size</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dbinfo['tables'] as $key => $table)
                                        <tr data-bs-toggle="collapse" data-bs-target="#row{{$key}}-details" class="clickable-row db_tables" data-table="{{isset($table) ? $table->table_name : ''}}" data-size="{{isset($table) ? $table->index_size_mb : ''}}">
                                            <td>
                                                {{ $table->table_name }}
                                            </td>
                                            <td>
                                                {{ $table->total_rows }}
                                            </td>
                                            <td>
                                                {{ $table->data_size_mb }} MB
                                            </td>
                                            <td>
                                                {{ $table->table_type }}
                                            </td>
                                            <td>
                                                {{ $table->collation }}
                                            </td>
                                            <td>
                                                {{ $table->trigger_count }}
                                            </td>
                                            <td>
                                                {{ $table->index_count }}
                                            </td>
                                            <td>
                                                {{ $table->index_size_mb }} MB
                                            </td>
                                            <td>
                                                {{ $table->procedure_count }}
                                            </td>

                                            <td>
                                                {{ $table->total_size_mb }} MB
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="row{{$key}}-details">
                                            <td colspan="5">
                                                <table class="table table-bordered table-hover table-sm small">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Non Unique</th>
                                                            <th scope="col">Index Sequence</th>
                                                            <th scope="col">Column Name</th>
                                                            <th scope="col">Size (MB)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($dbinfo['indexes'] as $indexkey => $index)
                                                            <tr>
                                                            @if (isset($index->table_name) && ($index->table_name == $table->table_name))
                                                                <td>{{$index->index_name}}</td>
                                                                <td>{{$index->NON_UNIQUE}}</td>
                                                                <td>{{$index->SEQ_IN_INDEX}}</td>
                                                                <td>{{$index->COLUMN_NAME}}</td>
                                                                <td>{{$index->index_size_mb}}</td>
                                                            @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">Total</th>
                                        <th scope="col"></th>
                                        <th scope="col">{{isset($dbinfo['size']) ? $dbinfo['size']['MB'].' MB ('.$dbinfo['size']['GB'].' GB)' : '' }}</th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            @php
                $logFilePath = storage_path('logs/query_logs.json');
                $queryLogs = [];

                if (File::exists($logFilePath)) {
                    $queryLogs = json_decode(File::get($logFilePath), true);
                }
            @endphp
            <div class="col-md-3 flex-fill">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title">Query Analysis&nbsp;&nbsp;<span class="font-weight-bold">{{ ($queryLogs != null) && (count($queryLogs) > 0) ? 'Total Queries: ('.count($queryLogs).')': ''}}</span></div>
                        <div class="d-flex">
                            <div style="margin-left: 0.3rem;">
                                <select name="queryStateFilter" id="queryStateFilter" class="form-select form-select-sm">
                                    <option value="all">All</option>
                                    <option value="Slow">Slow</option>
                                    <option value="non-slow">Non-Slow</option>
                                </select>
                            </div>
                            <div style="margin-left: 0.3rem;">
                                <select name="dateFilter" id="dateFilter" class="form-select form-select-sm">
                                    <option value="all">All</option>
                                    <option value="today">Today</option>
                                    <option value="last7days">Last 7 days</option>
                                    <option value="last30days">Last 30 days</option>
                                    <option value="last90days">Last 90 days</option>
                                    <option value="last180days">Last 180 days</option>
                                </select>
                            </div>
                            <div  style="margin-left: 0.3rem;">
                                <input type="text" name="sql_tables" id="sql_tables" class="form-control form-control-sm ml-2" placeholder="Search"/>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-text table-responsive">
                            <table class="table table-bordered table-hover small" id="query_logs_table">
                                <thead>
                                    <tr>
                                        <th>SQL Query</th>
                                        <th>Execution Time (ms)</th>
                                        <th>Model</th>
                                        <th>Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($queryLogs != null)
                                        
                                        @forelse($queryLogs as $index => $log)
                                            <tr>
                                                <td>{{ $log['sql'] }}</td>
                                                <td>{{ $log['time'] }} {!! (isset($log['threshold']) && !is_null($log['threshold'])) ? '<span class="badge rounded-pill bg-danger float-end">' .ucfirst($log['threshold']).'</span>' : '' !!}</td>
                                                <td>{{ isset($log['model']) ? $log['model'] : '' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($log['timestamp'])->format('Y-m-d H:i:s') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No query logs found.</td>
                                            </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3 flex-fill">
                <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title"><span>Server Status</span></div>
                </div>
                    <div class="card-body">
                        <div class="card-text ">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="status-tab" data-bs-toggle="tab" data-bs-target="#status-tab-pane" type="button" role="tab" aria-controls="status-tab-pane" aria-selected="true">Status</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="processes-tab" data-bs-toggle="tab" data-bs-target="#processes-tab-pane" type="button" role="tab" aria-controls="processes-tab-pane" aria-selected="false">Processes</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="collations-tab" data-bs-toggle="tab" data-bs-target="#collations-tab-pane" type="button" role="tab" aria-controls="collations-tab-pane" aria-selected="false">Collations</button>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="status-tab-pane">
                                    <div class="d-flex justify-content-between mt-2 mb-2">
                                        <span>Network traffic since startup: <strong>{{$dbinfo['trafficStats']['total_traffic']}}</strong></span><span> Server Started Upon: <strong>{{$dbinfo['trafficStats']['server_started_at']}}</strong></span>
                                    </div>
                                    <table class="table table-bordered table-hover small">
                                        <thead>
                                        <tr>
                                            <th>Traffic</th>
                                            <th>#</th>
                                            <th>ø per hour</th>
                                            <th>Connections</th>
                                            <th>#</th>
                                            <th>ø per hour</th>
                                            <th>%</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Received</td>
                                                <td>{{ $dbinfo['trafficStats']['received'] }}</td>
                                                <td>{{ $dbinfo['trafficStats']['received_per_hour'] ?? 'N/A' }}</td>
                                                <td rowspan="3">Max. concurrent connections</td>
                                                <td rowspan="3">{{ $dbinfo['trafficStats']['max_concurrent_connections'] }}</td>
                                                <td rowspan="3">---</td>
                                                <td rowspan="3">---</td>
                                            </tr>
                                            <tr>
                                                <td>Sent</td>
                                                <td>{{ $dbinfo['trafficStats']['sent'] }}</td>
                                                <td>{{ $dbinfo['trafficStats']['sent_per_hour'] ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td>{{ $dbinfo['trafficStats']['total_traffic'] }}</td>
                                                <td>{{ $dbinfo['trafficStats']['total_per_hour'] ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Failed attempts</td>
                                                <td>{{ $dbinfo['trafficStats']['failed_attempts'] }}</td>
                                                <td>{{ $dbinfo['trafficStats']['failed_per_hour'] ?? 'N/A' }}</td>
                                                <td>Aborted</td>
                                                <td>{{ $dbinfo['trafficStats']['aborted'] ?? 0 }}</td>
                                                <td>{{ $dbinfo['trafficStats']['aborted_per_hour'] ?? 0 }}</td>
                                                <td>0%</td>
                                            </tr>
                                            <tr>
                                                <td>Total</td>
                                                <td>{{ $dbinfo['trafficStats']['connections'] }}</td>
                                                <td>{{ $dbinfo['trafficStats']['connections_per_hour'] ?? 'N/A' }}</td>
                                                <td colspan="3"></td>
                                                <td>100%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="processes-tab-pane">
                                    <div class="d-flex justify-content-between mt-2 mb-2">
                                        <span>Auto-refreshed on every <strong>10</strong> seconds</span>
                                        <div>
                                            <button class="btn btn-sm btn-primary" onclick="fetchProcessList();"><i class="fa fa-refresh"></i></button>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-hover small">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Host</th>
                                            <th>Database</th>
                                            <th>Command</th>
                                            <th>Time</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody id="process-list">
                                            
                                        </tbody>
                                    </table>
                                </div>

                                <div role="tabpanel" class="tab-pane table-responsive" id="collations-tab-pane">
                                    <table class="table table-bordered table-hover small">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>CHARACTER SET NAME</th>
                                                <th>IS DEFAULT</th>
                                                <th>IS COMPILED</th>
                                                <th>SORTLEN</th>
                                                <th>PAD ATTRIBUTE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ( $dbinfo['collations'] as $collation)
                                            <tr>
                                                <td>{{$collation->COLLATION_NAME}}</td>
                                                <td>{{$collation->CHARACTER_SET_NAME}}</td>
                                                <td>{{$collation->IS_DEFAULT}}</td>
                                                <td>{{$collation->IS_COMPILED}}</td>
                                                <td>{{$collation->SORTLEN}}</td>
                                                <td>{{$collation->PAD_ATTRIBUTE}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
@section('mysqlinfo::script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (document.querySelector('.main-container')) {
                fetchProcessList();
                // setInterval(() => {
                //     fetchProcessList();
                // }, 10000);
                document.getElementById('search_tables').addEventListener("keyup", function(e) {
                    let value = this.value;
                    if(value == ""){
                        document.querySelectorAll(".db_tables").forEach(function(extensionElement) {
                            extensionElement.classList.remove("d-none");
                        });
                    } else {
                        document.querySelectorAll(".db_tables").forEach(function(extensionElement) {
                            if (extensionElement.dataset.table.toLowerCase().includes(value.toLowerCase()) || extensionElement.dataset.size.toLowerCase().includes(value.toLowerCase())) {
                                extensionElement.classList.remove("d-none");
                            } else {
                                extensionElement.classList.add("d-none");
                            }
                        });
                    }
                });
                
                document.getElementById('dateFilter').addEventListener('change', function (event) {
                    const filter = event.target.value;
                    const now = new Date();
                    
                    document.querySelectorAll('#query_logs_table tbody tr').forEach(function (row) {
                        const timestamp = row.querySelector('td:last-child').textContent;
                        const rowDate = new Date(timestamp);
        
                        if (filter === 'all') {
                            row.style.display = 'table-row';
                        } else if (filter === 'today') {
                            // Show rows with today's date
                            const today = now.toISOString().split('T')[0];
                            const rowDay = rowDate.toISOString().split('T')[0];
                            if (rowDay === today) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        } else if (filter === 'last7days') {
                            // Show rows from the last 7 days
                            const sevenDaysAgo = new Date(now);
                            sevenDaysAgo.setDate(now.getDate() - 7);
        
                            if (rowDate >= sevenDaysAgo && rowDate <= now) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        } else if (filter === 'last30days') {
                            // Show rows from the last 30 days
                            const thirtyDaysAgo = new Date(now);
                            thirtyDaysAgo.setDate(now.getDate() - 30);
        
                            if (rowDate >= thirtyDaysAgo && rowDate <= now) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        } else if (filter === 'last90days') {
                            // Show rows from the last 90 days
                            const ninetyDaysAgo = new Date(now);
                            ninetyDaysAgo.setDate(now.getDate() - 90);
        
                            if (rowDate >= ninetyDaysAgo && rowDate <= now) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        } else if (filter === 'last180days') {
                            // Show rows from the last 180 days
                            const oneHundredEightyDaysAgo = new Date(now);
                            oneHundredEightyDaysAgo.setDate(now.getDate() - 180);
        
                            if (rowDate >= oneHundredEightyDaysAgo && rowDate <= now) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        }


                        const queryTimeCell = row.querySelector('td:nth-child(2)'); // Execution Time (ms) column
                        const timestampCell = row.querySelector('td:nth-child(4)'); // Timestamp column

                        const queryTime = parseFloat(queryTimeCell ? queryTimeCell.textContent : 0);
                        let queryStateFilter = document.getElementById('queryStateFilter').value;
                        if (queryStateFilter === 'all') {
                            row.style.display = 'table-row';
                        } else if (queryStateFilter === 'Slow') {
                            if (queryTime > 150) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        } else if (queryStateFilter === 'non-slow') {
                            if (queryTime <= 150) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });
                });


                document.getElementById('queryStateFilter').addEventListener('change', function (event) {
                    const filter = event.target.value;
                    const now = new Date();
                    
                    document.querySelectorAll('#query_logs_table tbody tr').forEach(function (row) {
                        const queryTimeCell = row.querySelector('td:nth-child(2)'); // Execution Time (ms) column
                        const timestampCell = row.querySelector('td:nth-child(4)'); // Timestamp column

                        const queryTime = parseFloat(queryTimeCell ? queryTimeCell.textContent : 0);
                        console.log(queryTimeCell);
                        if (filter === 'all') {
                            row.style.display = 'table-row';
                        } else if (filter === 'Slow') {
                            if (queryTime > 150) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        } else if (filter === 'non-slow') {
                            if (queryTime <= 150) {
                                row.style.display = 'table-row';
                            } else {
                                row.style.display = 'none';
                            }
                        }
                    });
                });

                const dateFilter = document.getElementById('dateFilter');
                dateFilter.dispatchEvent(new Event('change'));
            }
        });

        function fetchProcessList() {
            // Create an XMLHttpRequest object
            const xhr = new XMLHttpRequest();

            // Define the endpoint
            const url = '{{route("processlist")}}';

            // Open the request
            xhr.open('GET', url, true);

            // Set the response type
            xhr.responseType = 'json';

            // Define the callback function
            xhr.onload = function () {
                if (xhr.status === 200 && xhr.response.success) {
                    // Clear the existing table rows
                    const tbody = document.getElementById('process-list');
                    tbody.innerHTML = '';

                    // Populate the table with the response data
                    const processList = xhr.response.data;
                    processList.forEach((process) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${process.Id}</td>
                            <td>${process.User}</td>
                            <td>${process.Host}</td>
                            <td>${process.db || 'None'}</td>
                            <td>${process.Command}</td>
                            <td>${process.Time}</td>
                            <td>${process.State || 'None'}</td>
                        `;
                        tbody.appendChild(row);
                    });
                } else {
                    console.error('Failed to fetch process list:', xhr.status, xhr.statusText);
                }
            };

            // Send the request
            xhr.send();
        }
    </script>
@endsection