# Detalhes
* Servidor Apache
* PHP >= 5.6
* Slim Framework 2.6.3

### Banco de dados
O nome do banco de dados é *db_davidt*. Para alterar o nome do banco de dados editar o arquivo **models/config.php**

# EndPoints

## Listagens
```
GET api/{collection}/?limit={int}&orderby[{field1}]={asc|desc}&orderby[{field2}]=[asc|desc]&field3=YYY&field4=ZZZ
```
Substituir {collection} por *cidades* ou *estados*

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
[{"id": "2", "nome": "Niteroi", "estadoId": "1", "criacao":"2018-06-20 22:23:10", "alteracao": "2018-06-20 22:23:10"}, {...}, {...}, {...}, ...]
```

## Inserir
```
POST api/{collection}
```
Substituir {collection} por *cidades* ou *estados*

**Request Body (cidades)**
```
 {"nome": "Niteroi", "estadoId": "1"}
```

**Request Body (estados)**
```
 {"nome": "Sao Paulo", "abreviacao": "SP"}
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

Substituir {_id} por o id do documento

**Reques Body (cidades)**
```
{"nome": "Niteroi", ...}
```

**Reques Body (estados)**
```
{"nome": "Acre", ...}
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

Substituir {_id} por o id do documento

**Response**

Retorna a quantidade de documentos excluidos(deletedCount).

```
{"deletedCount": "1"}
```

# Para POST, PUT

*Header request*
```
Content-Type: application/json; charset=utf-8
```
