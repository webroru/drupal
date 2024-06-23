Build scss
`docker run -it --rm -v="${PWD}/web/themes/custom/ntb":/app -w=/app node:alpine npm run build:sass`

Use node container
`docker run -it --rm -v="$PWD":/app -w=/app  --entrypoint sh node:alpine`
