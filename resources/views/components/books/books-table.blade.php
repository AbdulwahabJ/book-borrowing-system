<div class="mt-6">
    <table id="books-table">
        <thead class="text-white">
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Available Copies</th>
                <th>Borrow</th>
                <th id="column-pdf" style="display: none;">Show Book</th>
                <th id="column-actions" style="display: none;">Actions</th>
            </tr>
        </thead>
        <tbody class="text-gray-800">
        </tbody>
    </table>
</div>

//script...
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
                }

                initializeDataTable();
            },
            error: function(xhr, status, error) {
                console.error('Error fetching permissions:', error);
            }
        });

        function initializeDataTable() {
            $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('books.data') }}',
                columns: [{
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'author',
                        name: 'author'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },
                    {
                        data: 'available_copies',
                        name: 'available_copies',
                        render: function(data, type, row) {
                            return data > 0 ? data :
                                '<span class="text-danger">Not Available</span>';
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            if (row.available_copies > 0) {
                                return '<a href="/borrow/create/' + data +
                                    '" class="btn btn-success">Borrow Book</a>';
                            } else {
                                return '<span class="text-muted">Unavailable</span>';
                            }
                        }
                    },
                    userPermissions.includes('managing-books') ? {
                        data: 'pdf_file',
                        render: function(data, type, row) {
                            if (data) {
                                return '<a href="' + '{{ asset('storage') }}' + '/' + data +
                                    '" class="btn btn-outline-info" target="_blank">Download PDF</a>';
                            } else {
                                return 'Book Not Uploaded';
                            }
                        }
                    } : null,
                    userPermissions.includes('managing-books') ? {
                        data: 'id',
                        render: function(data, type, row) {
                            let editUrl = "/books/edit/" + data;
                            let deleteUrl = "/books/delete/" + data;
                            return '<a href="' + editUrl +
                                '" class="btn btn-outline-primary " style="width: 80px; height: 35px;">Edit</a>' +
                                '<form action="' + deleteUrl +
                                '" method="POST"  onsubmit="return confirm(\'Are you sure to delete this book?\')">' +
                                '@csrf' + '@method('DELETE')' +
                                '<button type="submit" class="btn btn-outline-danger mt-2"  style="width: 80px;height: 35px;">Delete</button>' +
                                '</form>';
                        }
                    } : null
                ].filter(Boolean)
            });
        }
    });
</script>

<style>
    #books-table tbody tr:hover {
        color: white !important;
        background-color: #0b1f46 !important;
    }
</style>
