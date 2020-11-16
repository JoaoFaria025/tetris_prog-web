const scorePlayer = document.getElementById("score");//const usadas depois para setar os atributos
const timerPlayer = document.getElementById("tempo");
const linesPlayer = document.getElementById("linhaseliminadas");
const dificultPlayer = document.getElementById("dificuldade");
var line;//tabuleiro dimensão
var col;
const tamPecas = 25; //size peça
const backgroundTab = "#2c3e50"; //fundo color tab
const borderTab = "#ff5e57"; //bordar pra conseguir visualizar as peças e o size

function choice(){//função para selecionar o tamanho do tabuleiro *fazer validação
    var tabTAM = prompt("𝗘𝗦𝗖𝗢𝗟𝗛𝗔 𝗢 𝗧𝗔𝗕𝗨𝗟𝗘𝗜𝗥𝗢 𝗤𝗨𝗘 𝗗𝗘𝗦𝗘𝗝𝗔 𝗝𝗢𝗚𝗔𝗥\n𝟭 - Tabuleiro Clássico \n𝟮 - Tabuleiro Personalizado");
    if(tabTAM == 1){ //retorna as dimensões de cada tipo de tabuleiro
        col = 10;
        line = 20;
    }else{
        col = 22;
        line = 44;
    }
}