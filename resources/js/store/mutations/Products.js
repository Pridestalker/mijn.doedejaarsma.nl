export default {
    fetch_products(state) {
        state.products.product_status = 'loading';
    },
    fetch_products_success(state, products) {
        state.products.products = products;
        state.products.products_count = products.length;
        state.products.product_status = 'success';
    },
    fetch_products_error(state, error) {
        state.products.product_status = 'failure';
        console.log(error)
    }
}
