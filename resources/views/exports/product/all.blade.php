<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Naam</th>
            <th>Omschrijving</th>
            <th>Gebruiker</th>
            <th>Bedrijf</th>
            <th>Datum aanvraag</th>
            <th>Datum deadline</th>
            <th>Datum laatste aanpassing</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->user->name }}</td>
                <td>{{ $product->user->bedrijf()->first()->name }}</td>
                <td>{{ $product->created_at }}</td>
                <td>{{ $product->deadline }}</td>
                <td>{{ $product->updated_at }}</td>
                <td>{{ $product->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
