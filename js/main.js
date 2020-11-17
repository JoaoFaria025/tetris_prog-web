const scorePlayer = document.getElementById("score");//const usadas depois para setar os atributos
const timerPlayer = document.getElementById("tempo");
const linesPlayer = document.getElementById("linhaseliminadas");
const dificultPlayer = document.getElementById("dificuldade");
var cvs = document.getElementById("rt");
var context_tetris = cvs.getContext("2d");//declarando o efeito de jogo

var N_ROW = 0;//tabuleiro dimensão
var N_COL = 0;
var tabuleiro = [];
const tamPecas = 20; //size peça in px
//Variaveis do game.
let speed_peca= 100;
let dropStart = Date.now();//Frame atual do usuário inicial.
let score = 0;
let count_line = 0;

const backgroundTab = "black"; //fundo color tab
const borderTab = "red"; //bordar pra conseguir visualizar as peças e o size

     
 //Peças rotacionadas (90, 180,270 graus)
const I = [ [[0, 0, 0, 0],[1, 1, 1, 1],[0, 0, 0, 0],[0, 0, 0, 0],], [ [0, 0, 1, 0],[0, 0, 1, 0],[0, 0, 1, 0],[0, 0, 1, 0],], [ [0, 0, 0, 0],[0, 0, 0, 0],[1, 1, 1, 1],[0, 0, 0, 0],], [ [0, 1, 0, 0],[0, 1, 0, 0],[0, 1, 0, 0],[0, 1, 0, 0],]];
const J = [ [[1, 0, 0],[1, 1, 1],[0, 0, 0]], [ [0, 1, 1],[0, 1, 0],[0, 1, 0] ],[ [0, 0, 0],[1, 1, 1],[0, 0, 1] ],[ [0, 1, 0],[0, 1, 0],[1, 1, 0] ]];
const L = [ [[0, 0, 1],[1, 1, 1],[0, 0, 0]], [ [0, 1, 0],[0, 1, 0],[0, 1, 1] ], [ [0, 0, 0],[1, 1, 1],[1, 0, 0] ], [ [1, 1, 0],[0, 1, 0],[0, 1, 0] ]];
const O = [ [[0, 0, 0, 0],[0, 1, 1, 0],[0, 1, 1, 0],[0, 0, 0, 0],] ];
const T = [ [[0, 1, 0],[1, 1, 1],[0, 0, 0]],[[0, 1, 0],[0, 1, 1],[0, 1, 0]],[[0, 0, 0],[1, 1, 1],[0, 1, 0]],[[0, 1, 0],[1, 1, 0],[0, 1, 0]]];
const U = [ [[1, 0, 1],[1, 1, 1],[0, 0, 0]], [ [0, 1, 1],[0, 1, 0],[0, 1, 1]], [ [0, 0, 0],[1, 1, 1],[1, 0, 1]], [ [1, 1, 0],[0, 1, 0],[1, 1, 0]]];


function choice(){//função para selecionar o tamanho do tabuleiro *fazer validação
    var tabTAM = prompt("𝗘𝗦𝗖𝗢𝗟𝗛𝗔 𝗢 𝗧𝗔𝗕𝗨𝗟𝗘𝗜𝗥𝗢 𝗤𝗨𝗘 𝗗𝗘𝗦𝗘𝗝𝗔 𝗝𝗢𝗚𝗔𝗥\n𝟭 - Tabuleiro Clássico \n𝟮 - Tabuleiro Personalizado");
    if(tabTAM == 1){ //retorna as dimensões de cada tipo de tabuleiro
        N_COL = 10;
        N_ROW = 20;
        /*cvs.width = 280;//tamanho do canva p/ este tabuleiro
        cvs.width = 580;*/
    }else{
        N_COL = 22;
        N_ROW = 44;
        /*cvs.width = 500;//tamanho do canva p/ este tabuleiro
        cvs.width = 1000;*/
    }

    for (let linha = 0; linha < N_ROW; linha++) {
        tabuleiro[linha] = [];
        for(let coluna = 0; coluna < N_COL; coluna++) {
            tabuleiro[linha][coluna] = backgroundTab;
        }
    }
    
    layoutTetris();
}



function layoutTetris() { //Desenhar tabuleiro
    for (var linha = 0; linha < N_ROW; linha++) {
        for(var coluna = 0; coluna < N_COL; coluna++) {
            const cor_atual = tabuleiro[linha][coluna];
            Desenhar_quadradinho(coluna,linha,cor_atual);
        }
    }

}
function Desenhar_quadradinho(row,col,color){
    context_tetris.fillStyle = color; //Cor atual do quadradinho.
    context_tetris.fillRect(row * tamPecas , col * tamPecas , tamPecas, tamPecas);
    context_tetris.strokeStyle = borderTab;//Cor das linhas que dividem a coluna e as linhas.
    context_tetris.strokeRect(row * tamPecas , col * tamPecas , tamPecas , tamPecas );
}
// Constante de pecas.
const tetrominoes = [[I,"yellow"],[J,"blue"], [L,"purple"],[O,"cyan"],[T,"orange"],[U,"red"]];


//Classe Piece
class Pecas{
    constructor(peca,color){ 
        this.peca = peca;
        this.color = color;
        this.peca_index = 0; //Peça I, se for index 1: Peca J.
        this.activePeca = this.peca[this.peca_index]; //PECA ATUAL, QUE FOI GERADA ALEATORIAMENTE.
        this.x_board = 3; //x da matriz
        this.y_board = -2; //y da matriz 
        
    }
    fill_piece(color) { //Pintar a peça com uma cor.
        for(var linha = 0; linha < this.activePeca.length; linha++){
            for(var coluna = 0; coluna < this.activePeca.length; coluna++){   
                if(this.activePeca[linha][coluna] == 1){
                    Desenhar_quadradinho((this.x_board + coluna),(this.y_board + linha), color);

                }
            }
        }
    }

    draw() { //Desenhar a peça.
        this.fill_piece(this.color);
    }

    unDraw() { //Apagar as peças
        this.fill_piece(backgroundTab);
    }   
    
    moveDown() { //Movimentação cte da peça
        this.unDraw(); //Apagar a peça.
        this.y_board ++;
        this.draw();
      
    }
}

//Objeto do jogo.
let tetrominoes_obj = pecas_aleatorias();
// generate random PECASs

function pecas_aleatorias(){
    const peca_aleatoria  = Math.floor(Math.random() * tetrominoes.length) // Peça aleatoria de 0 a  6. O length se refere a qtd_pecas na const
    return new Pecas(tetrominoes[peca_aleatoria][0],tetrominoes[peca_aleatoria][1]); //Criar a peca aleatoria. Posicao 0: Tipo de peca; Posicao 1: Cor da peça.
}

function drop() {
    const now = Date.now();
    const delta = now - dropStart; //Hora do frame atual do usuario - a hora que a peça comecou a cair.

    if (delta >= speed_peca) {  //Se passou os 500ms.(Para ajustar a velo do jogo.)
        tetrominoes_obj.moveDown();
        dropStart = Date.now();//Atualizar o frame atual do usuário.
    }
    requestAnimationFrame(drop);
}

drop();




