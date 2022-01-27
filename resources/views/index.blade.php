@extends('template.main')

@section('content')
    @if ( !$hasRecords)
    <div class="d-flex flex-column m-4 mt-5 pt-5 align-items-center justify-content-center">
        <h3 class="h3 text-center">No Records found...</h3>
        <a href="/kangaroos/create" type="button" class="btn btn-primary pull-right">Add a Kangaroo</a>
    </div>
    @endif

    @if ($hasRecords)
    <div class="d-flex flex-row-reverse my-4">
        <a href="/kangaroos/create" type="button" class="btn btn-primary pull-right">Add a Kangaroo</a>
    </div>

    <div class="container-fluid p-0">
        <div id="dataGrid" class=""></div>
    </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(() => {
            function isNotEmpty(value) {
                return value !== undefined && value !== null && value !== '';
            }
            const store = new DevExpress.data.CustomStore({
                key: 'id',
                load(loadOptions) {
                    const deferred = $.Deferred();
                    const args = {};

                    [
                        'skip',
                        'take',
                        'requireTotalCount',
                        'requireGroupCount',
                        'sort',
                        'filter',
                        'totalSummary',
                        'group',
                        'groupSummary',
                    ].forEach((i) => {
                        if (i in loadOptions && isNotEmpty(loadOptions[i])) {
                            args[i] = JSON.stringify(loadOptions[i]);
                        }
                    });

                    $.ajax({
                        url: '/api/kangaroos?per_page=max&sort=-created_at',
                        dataType: 'json',
                        data: args,
                        success(result) {
                            deferred.resolve(result.data, {
                                totalCount: result.totalCount,
                                summary: result.summary,
                                groupCount: result.groupCount,
                            });
                        },
                        error() {
                            deferred.reject('Data Loading Error');
                        },
                        timeout: 5000,
                    });

                    return deferred.promise();
                },
            });

            $('#dataGrid').dxDataGrid({
                dataSource: store,
                showBorders: true,
                remoteOperations: false,
                paging: {
                    pageSize: 10,
                },
                pager: {
                    showPageSizeSelector: true,
                    allowedPageSizes: [5, 10, 20],
                },
                filterRow: {
                    visible: true,
                    applyFilter: 'auto',
                },
                searchPanel: {
                    visible: true,
                    width: 240,
                    placeholder: 'Search...',
                },
                headerFilter: {
                    visible: true,
                },
                editing: {
                    mode:'row',
                    useIcons: true,
                },
                columns: [
                    {
                        dataField: 'name',
                    },
                    {
                        dataField: 'birthday',
                        dataType: 'date',
                    },
                    {
                        dataField: 'weight',
                        caption: 'weight(kg)',
                    },
                    {
                        dataField: 'height',
                        caption: 'height(cm)',
                    },
                    {
                        dataField: 'friendliness',
                    },
                    {
                        caption: 'Action',  
                        type: "buttons",
                        buttons: [{   
                            text: 'Edit',
                            icon: 'edit',
                            hint: 'Edit',
                            onClick: function (e) {
                                let item = e.row.data;

                                location.href = `/kangaroos/${item.id}/edit`;
                            }
                        }]
                    },
                ],
            }).dxDataGrid('instance');
        });

    </script>
@endpush

