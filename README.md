# Passo a passo back - report

- Clonar repositório
  > git clone https://github.com/rothink/kanastra-read-files.git


- Entrar no repositório clonado
  >cd kanastra-read-files


- Subir os serviços com docker e instalar as dependências

  > make install    

- Sobe os workes
  > make worker

- Executar os testes
  >make test

- Executar os testes com coverage
  >make test-coverage

- cUrl para inserir arquivo
  >curl --request POST \
      --url http://localhost/api/upload \
      --header 'Content-Type: multipart/form-data' \
      --form 'input=@{caminho-para-o-arquivo}.csv' \
      --form =


![alt text](https://github.com/rothink/kanastra-read-files/blob/main/public/images/coverage.png?raw=true)

![alt text](https://github.com/rothink/kanastra-read-files/blob/main/public/images/workers.png?raw=true)
