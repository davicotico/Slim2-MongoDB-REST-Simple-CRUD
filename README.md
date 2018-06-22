### Detalhes
* Servidor Apache
* PHP >= 5.6
* Slim Framework 2.6.3

# EndPoints

## Listagens
```
GET api/{collection}/?limit={int}&orderby[{field1}]={asc|desc}&orderby[{field2}]=[asc|desc]&field3=YYY&field4=ZZZ
```
Substituir {collection} por cidades ou estados.

Podem ser pasados na URL os seguintes parâmetros:
* limit: O limite de objetos
* orderby: Permite a ordenação por mais de um campo de forma ascendente(asc) ou descendente(desc).
* O resto dos parâmetros são considerados filtros (campo e valor).

**Exemplo:**

```
GET api/cidades/?limit=15&orderby[criacao]=asc&orderby[nome]=desc&estadoId=1
```

**Response**
```
[{"id": "1", "nome": "Rio de Janeiro", "abreviacao": "RJ", ...}, {...}, {...}, {...}, ...]
```

## Inserir
```
POST api/{collection}
```
Substituir {collection} por *cidades* ou *estados*

**Request Body**
```
 {"field1": "zz", "field2": "yy"}
```
**Response**

Retorna o id do novo documento e a quantidade de documentos inseridos (Sendo que a operação permite uma inserção por request o valor insertedCount vai tomar o valor de 1 se for inserido corretamente ou 0 em caso contrario).
```
 {"id": "2", "insertedCount": "1"}
```

## Alterar
```
PUT api/{collection}/{_id}
```

Substituir {collection} por *cidades* ou *estados*

**Reques Body**
```
{"field1": "yyy", "field2": "zzz"}
```
**Response**

Retorna a quantidade de documentos que coincidiram com o criterio da busca(matchedCount) e a quantidade de documentos alterados (modifiedCount).

```
{"matchedCount": "1", "modifiedCount": "0"}
```

## Excluir
```
DELETE api/{collection}/{_id}
```
Substituir {collection} por *cidades* ou *estados*

**Response**

Retorna a quantidade de documentos excluidos(deletedCount).

```
{"deletedCount": "1"}
```

#### Para POST, PUT

*Header request*
```
Content-Type: application/json; charset=utf-8
```
