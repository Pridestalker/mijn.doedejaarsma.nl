@if(session('clearStorage'))
    <script>
        localStorage.removeItem('product_soort');
        localStorage.removeItem('product_omschrijving');
        localStorage.removeItem('product_name');
        localStorage.removeItem('product_kostenplaats');
        localStorage.removeItem('product_format');
        localStorage.removeItem('product_deadline');
        localStorage.removeItem('product_oplage');
        localStorage.removeItem('product_gewicht');
        localStorage.removeItem('product_afleveradres');
        localStorage.removeItem('product_referentie');
    </script>
@endif
