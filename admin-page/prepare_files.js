// prepare_files.js
const fs = require('fs');
const path = require('path');
const fastGlob = require('fast-glob');

const buildDir = path.resolve(__dirname, 'build/static');
const destDir = path.resolve(__dirname, '../assets');

async function MoveJS() {
  try {
    const files = await fastGlob(`${buildDir}/js/main.*.js`);

    files.forEach(file => {
      const fileNameWithHash = path.basename(file);
      const newFileName = 'main.js';
      const newFilePath = path.join(destDir + '/js', newFileName);

      if (!fs.existsSync(destDir + '/js')) {
        fs.mkdirSync(destDir + '/js', { recursive: true });
      }

      fs.rename(file, newFilePath, (err) => {
        if (err) {
          console.error('Erro ao mover e renomear o arquivo:', err);
        } else {
          console.log(`Arquivo ${fileNameWithHash} movido e renomeado para ${newFilePath}`);
        }
      });
    });
  } catch (err) {
    console.error('Erro ao buscar arquivos:', err);
  }
}

async function MoveCSS() {
  try {
    const files = await fastGlob(`${buildDir}/css/main.*.css`);

    files.forEach(file => {
      const fileNameWithHash = path.basename(file);
      const newFileName = 'main.css';
      const newFilePath = path.join(destDir + '/css', newFileName);

      if (!fs.existsSync(destDir + '/css')) {
        fs.mkdirSync(destDir + '/css', { recursive: true });
      }

      fs.rename(file, newFilePath, (err) => {
        if (err) {
          console.error('Erro ao mover e renomear o arquivo:', err);
        } else {
          console.log(`Arquivo ${fileNameWithHash} movido e renomeado para ${newFilePath}`);
        }
      });
    });
  } catch (err) {
    console.error('Erro ao buscar arquivos:', err);
  }
}

MoveJS();
MoveCSS();