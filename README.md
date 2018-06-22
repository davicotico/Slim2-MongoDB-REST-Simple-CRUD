# Slim2-MongoDB-REST-Simple-CRUD
Slim Framework 2  MongoDB REST Service Simple CRUD

## Detalhes
* Servidor Apache
* PHP >= 5.6
* Slim Framework 2.6.3

## EndPoints

### Listagens
```
GET api/{collection}/?limit={int}&orderby[{field1}]={asc|desc}&orderby[field2]=[asc|desc]&field3=YYY&field4=ZZZ
```
**Request Body**
(No body)

**Response**
```
[{"field1": "value1"}, {}, {}, {}, ...]
```

**Exemplo:**

```
GET api/cidades/?limit=15&orderby[criacao]=asc&orderby[nome]=desc&estadoId=1
```

### Inserir
```
POST api/{collection}
```
Substituir {collection} por cidades ou estados

**Request Body**
```
 {"field1": "zz", "field2": "yy"}
```

### Alterar
```
PUT api/{collection}/{_id}
```
Substituir {collection} por cidades ou estados

**Reques Body**
```
{"field1": "yyy", "field2": "zzz"}
```

### Excluir
```
DELETE api/{collection}/{_id}
```
Substituir {collection} por cidades ou estados

**Reques Body**
```
No body
```

#### Para POST, PUT

*Header request*
```
Content-Type: application/json; charset=utf-8
```
