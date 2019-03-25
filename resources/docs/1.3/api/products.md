# Products
The api endpoint to fetch products.

---

## Products

> {warning} You need to be logged in to use these endpoints.

### Endpoints
| Method   | URI                              | Headers               |
| :-       | :-                               | :-                    |
| GET,HEAD | api/{version}/products           | Authorization,Default |
| POST     | api/{version}/products           | Authorization,Default |
| GET,HEAD | api/{version}/products/{product} | Authorization,Default |
| DELETE   | api/{version}/products/{product} | Authorization,Default |
| PATCH    | api/{version}/products/{product} | Authorization,Default |

> {info} These endpoints require a {version} parameter

### URL Params

`GET api/{version}/products` takes the following parameters

```yaml
status:
    type: String
    default: ""
    required: false,
    depends_on:

product_name:
    type: String
    default: "",
    required: false,
    depends_on:
    
order_by:
    type: String
    default: ""
    required: false
    depends_on:

order:
    type: String
    one_of: 
      - 'ASC'
      - 'DESC'
    default: 'ASC'
    required: false
    depends_on: order_by
```

Other requests

```python
None
```

### Data Params

`POST api/{version}/products` takes the following body

```json
{
  ""
}
```
