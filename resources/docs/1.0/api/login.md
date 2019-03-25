# API
De [DTP applicatie](/) werkt met een basis API. hiermee kunnen Producten worden aangevraagd.

---

- [Login](#login)

<a name="login"></a>
## Login

### Endpoints

| Method | URI       | Headers |
| :-     | :-        | :-      |
| POST   | api/login | default |

### URL Params

```python
None
```

### Data Params

```json
{
  "email": "email",
  "password": "string" 
}
```

> {info} The password is an unencrypted string.

### Returns

> {success} Status code `200`

This returns the following JSON object:

```json
{
  "access_token": "hashed_string",
  "type": "Bearer"
}
```

> {danger} Status code `403`

The login attempt was not successful
