
# Desafio - Grupo Zap  
  
Esse incrivel projeto foi escrito se baseando no framework Lumen, sendo pensado no conceito de service handler bus, onde conseguimos seguir facilmente os conceitos do S.O.L.I.D, principalmente o 'S'.  
  
  
## Requisitos  
  
Para o perfeito funcionamento desse projeto, você vai precisar instalar:  
- PHP 7.2.5 (ou superior)  
- Extensão PHP Mbstring  
- Composer  
  
Também e possível utilizar o projeto utilizando Docker com docker-compose (método recomendado). Dessa forma, e necessário ter apenas as duas aplicações de forma local.  
  
## Instalação  
  
A instalação do projeto e simples, sendo necessário executar o comando `composer install`. Dessa forma, o Composer vai instalar todas as dependências necessárias no projeto.  
Caso voce escolha utilizar Docker, não e necessário ter o Composer localmente e poderá utilizar o já instalado no contanier com o seguinte comando: `docker-compose exec app composer update`  
  
## Testes  
  
Seguindo a mesma mecânica de com docker/sem docker, você pode executar os testes da seguinte forma:  
- Docker: docker-compose exec app ./vendor/bin/phpunit  
- Sem Docker: ./vendor/bin/phpunit  
  
## Endpoints  
  
O sistema contem os seguintes endpoints:  
- GET /properties/zap  
    Retorna todos os imoveis elegíveis para o portal Zap  
- GET /properties/viva-real  
    Retorna todos os imoveis elegíveis para o portal Viva Real  

 Todos os endpoints fornecem uma interface para paginação via query string, onde:
- page: número inteiro onde você pode definir a página atual da paginação
- pageSize: número inteiro onde você pode definir a quantidade de itens por página 
      
## Consideraçoes finais  
- Por questao de simplicidade, recomendo utilizar o Docker para a execuçao do projeto. A porta padrao e a :8080  
- A utilizaçao de handlers nos services nos proporciona diversos beneficios tecnicos, como adequaçao aos conceitos do S.O.L.I.D, facilidade de manutencao e reutilizaçao de codigo  
- A performance da aplicaçao
