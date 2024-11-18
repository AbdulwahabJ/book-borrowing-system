<div class="mt-6">
    <table id="borrowing-table">
        <thead class="text-white">
            <tr>
                <th>borrower name</th>
                <th>Book</th>
                <th>Borrowed at</th>
                <th>Returned at</th>
                <th id="column-return-status" style="display: none;">Return Status</th>

                <th id="column-actions" style="display: none;">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-800"></tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        let userPermissions = [];
        $.ajax({
            url: '{{ route('user.permissions') }}',
            method: 'GET',
            success: function(permissions) {
                userPermissions = permissions;

                if (userPermissions.includes('managing-books')) {
                    $('#column-pdf').show();
                    $('#column-actions').show();
                    $('#column-return-status').show();

                }

                initializeDataTable();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching permissions:', error);
            }
        });

        function initializeDataTable() {

            $('#borrowing-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('borrow.data') }}',
                columns: [{
                        data: 'user_name',
                        name: 'user_name'
                    },
                    {
                        data: 'book_title',
                        name: 'book_title'
                    },
                    {
                        data: 'borrowed_at',
                        name: 'borrowed_at'
                    },
                    {
                        data: 'returned_at',
                        name: 'returned_at'
                    },
                    userPermissions.includes('managing-books') ? {
                        data: 'returned_at',
                        render: function(data, type, row) {
                            let deleteUrl = "/borrow/delete/" + row.id;

                            let isReturnedTimePassed = new Date() > new Date(row.returned_at);

                            if (isReturnedTimePassed) {
                                return `
            <form action="${deleteUrl}" method="POST" onsubmit="return confirm('Is book returned?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-warning return-btn">Time to return</button>
            </form>
        `;
                            } else {
                                return 'Not yet';
                            }
                        }
                    } : null,

                    userPermissions.includes('managing-books') ? {
                        data: 'id',
                        render: function(data, type, row) {
                            let editUrl = "/borrow/edit/" + data;
                            let deleteUrl = "/borrow/delete/" + data;
                            return '<a href="' + editUrl +
                                '" class="btn btn-outline-primary " style="width: 80px; height: 35px;">Edit</a>' +

                                ` <form action="${deleteUrl}" method="POST" onsubmit="return confirm('sure you want to delete?')">
                                    @csrf
                                    @method('DELETE')
                                   <button type="submit" class="btn btn-outline-danger mt-2 " style="width: 80px; height: 35px;">Delete</button>
                                 </form>`;
                        },
                    } : null
                ].filter(Boolean)

            });
        }

        function updateReturnButtons() {
            $('#borrowing-table tbody tr').each(function() {
                let row = $(this);
                let returnedAt = row.find('td').eq(3)
                    .text();
                let deleteUrl = "/borrow/delete/" + row.id;

                if (returnedAt && new Date() > new Date(returnedAt)) {
                    if (!row.find('.return-btn').length) {
                        row.find('td').eq(4).html(

                     ` <form action="${deleteUrl}" method="POST" onsubmit="return confirm('Is book returned?')">
                      @csrf
                       @method('DELETE')
                      <button type="submit" class="btn btn-warning return-btn">Time to return</button>
                      </form> `
                        );
                    }
                }
            });
        }
        setInterval(updateReturnButtons, 5000);
    });
</script>

<style>
    #borrowing-table tbody tr:hover {
        color: white !important;
        background-color: #0b1f46 !important;
    }
</style>
