<table class="table text-white allocate-table-body ">
    <tr>
        <th>No</th>
        <th>Username</th>
        <th>Bergabung</th>
    </tr>
    @forelse($data as $index=>$d)
    <tr>
        <td>{{++$index}}</td>
        <td>{{isset($d->user) ? $d->user->username : null}}</td>
        <td>{{isset($d->user) ? date('Y-m-d',strtotime($d->user->created_at)) : null}}</td>
    </tr>
    @empty
    <tr>
        <td colspan="3" class="text-center">Data Tidak Ditemukan</td>
    </tr>
    @endforelse
</table>