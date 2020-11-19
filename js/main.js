
//------------- Constantes ------------------
const scorePlayer = document.getElementById("score");//const usadas depois para setar os atributos
const linesPlayer = document.getElementById("linhaseliminadas");
const dificultPlayer = document.getElementById("dificuldade");
const backgroundTab = "#0a0b19"; //fundo color tab
const borderTab = "red"; //bordar pra conseguir visualizar as peças e o size

//------------- CANVAS ------------------
var cvs = document.getElementById("rolling_tetris");
var context_tetris = cvs.getContext("2d");//declarando o efeito de jogo
var nextCanvas = document.getElementById('Next_piece');
var nextBlocks = nextCanvas.getContext("2d");
document.getElementById("restart-btn").style.display = "none";
// ----------- Variaveis do game ------------
let tamPecas = 20; //size peça in px
var N_ROW = 0;//tabuleiro dimensão
var N_COL = 0;
var tabuleiro = [];
let speed_peca= 500;
let dropStart = Date.now();//Frame atual do usuário inicial.
let score = 0;
let count_line = 0;
var minutes = 0;
var seconds = 0;
var timerMilesimos = 1000; //1 segundo tem 1000 milésimos
var timerPlayer = 0;
var qtdLinhas = 0; //conta a quantidade de linhas eliminadas
var sequenciaLinhas = 0; //sequencia de linhas eliminadas de uma vez so (para calculo da pontuacao bonus)

// ----------- Classe PECAS------------

class Pecas{
    constructor(peca,color){ 
        this.peca = peca;
        this.color = color;
        this.peca_next=null;
        this.peca_index = 0; //Peça I, se for index 1: Peca J.
        this.activePeca = this.peca[this.peca_index]; //PECA ATUAL, QUE FOI GERADA ALEATORIAMENTE.
        this.x_board = 3; //x da matriz
        this.y_board = -2; //y da matriz 
        
    }
}
     
// ----------- Constantes das peças (tetrominoes) ------------

//Peças rotacionadas (90, 180,270 graus)
const I = [ [[0, 0, 0, 0],[1, 1, 1, 1],[0, 0, 0, 0],[0, 0, 0, 0],], [ [0, 0, 1, 0],[0, 0, 1, 0],[0, 0, 1, 0],[0, 0, 1, 0],], [ [0, 0, 0, 0],[0, 0, 0, 0],[1, 1, 1, 1],[0, 0, 0, 0],], [ [0, 1, 0, 0],[0, 1, 0, 0],[0, 1, 0, 0],[0, 1, 0, 0],]];
const J = [ [[1, 0, 0],[1, 1, 1],[0, 0, 0]], [ [0, 1, 1],[0, 1, 0],[0, 1, 0] ],[ [0, 0, 0],[1, 1, 1],[0, 0, 1] ],[ [0, 1, 0],[0, 1, 0],[1, 1, 0] ]];
const L = [ [[0, 0, 1],[1, 1, 1],[0, 0, 0]], [ [0, 1, 0],[0, 1, 0],[0, 1, 1] ], [ [0, 0, 0],[1, 1, 1],[1, 0, 0] ], [ [1, 1, 0],[0, 1, 0],[0, 1, 0] ]];
const O = [ [[0, 0, 0, 0],[0, 1, 1, 0],[0, 1, 1, 0],[0, 0, 0, 0],] ];
const T = [ [[0, 1, 0],[1, 1, 1],[0, 0, 0]],[[0, 1, 0],[0, 1, 1],[0, 1, 0]],[[0, 0, 0],[1, 1, 1],[0, 1, 0]],[[0, 1, 0],[1, 1, 0],[0, 1, 0]]];
const U = [ [[1, 0, 1],[1, 1, 1],[0, 0, 0]], [ [0, 1, 1],[0, 1, 0],[0, 1, 1]], [ [0, 0, 0],[1, 1, 1],[1, 0, 1]], [ [1, 1, 0],[0, 1, 0],[1, 1, 0]]];
//Peças e suas cores.
const tetrominoes = [[I,"#55E6C1"],[J,"#1B9CFC"], [L,"#ffcccc"],[O,"#32ff7e"],[T,"#c23616"],[U,"#ffffff"]];



// ----------- Função para selecionar o tamanho do tabuleiro *fazer validação ------------
function choice(){
    var tabTAM = prompt("𝗘𝗦𝗖𝗢𝗟𝗛𝗔 𝗢 𝗧𝗔𝗕𝗨𝗟𝗘𝗜𝗥𝗢 𝗤𝗨𝗘 𝗗𝗘𝗦𝗘𝗝𝗔 𝗝𝗢𝗚𝗔𝗥\n𝟭 - Tabuleiro Clássico \n𝟮 - Tabuleiro Personalizado");
    if(tabTAM == 1){ //retorna as dimensões de cada tipo de tabuleiro
        N_COL = 10;
        N_ROW = 20;
         //TAMANHO DESSE: WIDTH 200; 400 height;
        
    }else{
        N_COL = 22;
        N_ROW = 44;
        cvs.setAttribute("height", "616");
        cvs.setAttribute("width", "308");
        tamPecas = 14;
       //TAMANHO DESSE: WIDTH 440px; 880 height;
    }

    for (let linha = 0; linha < N_ROW; linha++) {
        tabuleiro[linha] = [];
        for(let coluna = 0; coluna < N_COL; coluna++) {
            tabuleiro[linha][coluna] = backgroundTab;
        }
    }
    layoutTetris();
    startTimer(); //inicia o cronomêtro
}


// ----------- Desenhar o tabuleiro (DrawBoard) ------------
function layoutTetris() { 
    for (var linha = 0; linha < N_ROW; linha++) {
        for(var coluna = 0; coluna < N_COL; coluna++) {
            const cor_atual = tabuleiro[linha][coluna];
            Desenhar_quadradinho(coluna,linha,cor_atual);
        }
    }

}

// ----------- Desenhar o nextPiece  ------------

function drawNextPiece(next){  
    nextCanvas.width = 100;
    nextCanvas.height = 100;
    for (let linha = 0; linha < next.activePeca.length;  linha++) { 
        for (let coluna = 0; coluna < next.activePeca.length ; coluna++) {
            if(next.activePeca[linha][coluna] == 1){
                Desenhar_NEXT_quadradinhos(linha,coluna, next.color);
            }
        }
    }  
}
function Desenhar_NEXT_quadradinhos(row,col,color){
    nextBlocks.fillStyle = color ; //Define a cor do bloco gerado
    nextBlocks.fillRect(col*tamPecas, row*tamPecas, tamPecas, tamPecas);//Linha*tamDoBloco,Coluna*TamDoBloco, TamDoBloco,TamDoBloco
    nextBlocks.strokeRect(col*tamPecas, row*tamPecas, tamPecas, tamPecas);
}

// ----------- Desenhar a peça padrao (Piece (Tetrominoes)) ------------

function Desenhar_quadradinho(row,col,color){
    context_tetris.fillStyle = color; //Cor atual do quadradinho.
    context_tetris.fillRect(row * tamPecas , col * tamPecas , tamPecas, tamPecas);
    context_tetris.strokeStyle = borderTab;//Cor das linhas que dividem a coluna e as linhas.
    context_tetris.strokeRect(row * tamPecas , col * tamPecas , tamPecas , tamPecas );
}

// ----------- Objetos ------------

let tetrominoes_obj = pecas_aleatorias();
let next_piece = pecas_aleatorias();
//Desenhar a proxima peça
drawNextPiece(next_piece);


// ----------- Gerar peças aleatorias ------------

function pecas_aleatorias(){
    const peca_aleatoria  = Math.floor(Math.random() * tetrominoes.length) // Peça aleatoria de 0 a  6. O length se refere a qtd_pecas na const
    return new Pecas(tetrominoes[peca_aleatoria][0],tetrominoes[peca_aleatoria][1]); //Criar a peca aleatoria. Posicao 0: Tipo de peca; Posicao 1: Cor da peça.
}


// ----------- Movimentação da peça! ------------

function Movimentation() {
    //Movimentação da peça!!
    let gameOver = false;
    const now = Date.now();
    const delta = now - dropStart; //Hora do frame atual do usuario - a hora que a peça comecou a cair.
    if (delta >= speed_peca) {  //Se passou os 500ms.(Para ajustar a velo do jogo.)
        moveDown();
        dropStart = Date.now();//Atualizar o frame atual do usuário.
    }
    if(!gameOver){
        requestAnimationFrame(Movimentation);
    }
    
   
}
Movimentation();

//Pintura de cada peça!!
function fill_piece(color) { //Pintar a peça com uma cor.
    for(var linha = 0; linha < tetrominoes_obj.activePeca.length; linha++){
        for(var coluna = 0; coluna < tetrominoes_obj.activePeca.length; coluna++){   
            if(tetrominoes_obj.activePeca[linha][coluna] == 1){
                Desenhar_quadradinho((tetrominoes_obj.x_board + coluna),(tetrominoes_obj.y_board + linha), color);
            }
        }
    }
}

//Desenhar a peça.
function drawPieces() { 
    fill_piece(tetrominoes_obj.color);
}

//Apagar as peças
function deletePiece() { 
    fill_piece(backgroundTab);
}   

//Movimentação da peça para baixo
function moveDown() { 
    if(!CheckCollision(0,1,tetrominoes_obj.activePeca)){
        //Se não estiver colidindo com nada, ela pode continuar descendo!!
        deletePiece(); //Apagar a peça.
        tetrominoes_obj.y_board ++;
        drawPieces();
        return;
    }
    else{
        //Se ela colidir, então:
        //Trava a movimentação dela:
        lock();
        //Gera a proxima peça.
        tetrominoes_obj = next_piece;
        next_piece = pecas_aleatorias();
        drawNextPiece(next_piece);
    } 
}

//Mover para direita
function moveRight(){
    if (!CheckCollision(1, 0, tetrominoes_obj.activePeca)) {
    deletePiece(); //Apagar a peça.
    tetrominoes_obj.x_board ++;
    drawPieces();
    }
}

//Mover para Esquerda
function moveLeft(){
    if (!CheckCollision(-1, 0, tetrominoes_obj.activePeca)) {
        deletePiece(); //Apagar a peça.
        tetrominoes_obj.x_board --;
        drawPieces();
    }
}

//Rotação da peça:
Pecas.prototype.rodar = function(){
    let peca_padrao = tetrominoes_obj.peca[(tetrominoes_obj.peca_index + 1) % tetrominoes_obj.peca.length];
    let mov = 0;
    if (CheckCollision(0, 0, peca_padrao)) {
        mov = 1;
        if (tetrominoes_obj.x_board > N_COL / 2) {
            mov = -1;
        }
    }
    if (!CheckCollision(mov, 0, peca_padrao)) {
        deletePiece(); //Apagar a peça.
        tetrominoes_obj.x_board += mov;
        tetrominoes_obj.peca_index = (tetrominoes_obj.peca_index + 1) % tetrominoes_obj.peca.length;
        tetrominoes_obj.activePeca = tetrominoes_obj.peca[tetrominoes_obj.peca_index];
        drawPieces();
    }
}
    
document.onkeydown = function (e) {
    switch (e.key) {
        case 'ArrowUp':
            tetrominoes_obj.rodar();
            break;
        case 'ArrowDown':
            moveDown();
            break;
        case 'ArrowLeft':
            moveLeft();
            break;
        case 'ArrowRight':
            moveRight();
        }
};

//Funcao para checar a colisao das peças
function CheckCollision(row, col, futurePiece) { 
    for (var linha = 0; linha < futurePiece.length; linha++) {
        for (var coluna = 0; coluna < futurePiece.length; coluna++) {
            if(futurePiece[linha][coluna] != 0 ) { //Se existir alguma peça nessa coluna e linha! 
                var newRow = tetrominoes_obj.x_board + coluna + row;
                var newCol = tetrominoes_obj.y_board + linha + col;

                // Checar os limites do tabuleiro. Se a peça está colidindo com o X=0 (board esquerdo);
                // Se peça chegou no limite do tabuleiro (final de linhas)
                // Se a peça não ultrapassou o limite do board direito
                if (newRow < 0 || newRow >= N_COL || newCol >= N_ROW) {
                    //Colisão para as bordas
                    return true;
                    //Se trombar com alguma peça, retorne true!!
                }   
                if (newCol < 0) {
                    //Colisão para as bordas
                    continue;
                }
                if (tabuleiro[newCol][newRow] != backgroundTab) {
                    //Colidir com algum quadrado que já esteja pintado.
                    return true;
                    }
            }
            else{
                continue;
            }
                    
        }
    }
    return false;
}

//Travar as peças quando colidir

function lock(){
    for(var linha = 0; linha < tetrominoes_obj.activePeca.length; linha++){
        for(var coluna = 0; coluna < tetrominoes_obj.activePeca.length; coluna++){
            if(tetrominoes_obj.activePeca[linha][coluna] == 0 ){ 
                //Se não encostar em nenhuma peça
                continue;
            }
            else if(tetrominoes_obj.y_board + linha < 0){
                //Se estiver acima do quadro, é pq deu gameover. (ROLLING TETRIS MUDAR!!).
               // gameOver();
               gameOver = true;
               
               alert("Você perdeu :(");
               restartGame();
                break;
            }
            else{
            tabuleiro[tetrominoes_obj.y_board + linha][tetrominoes_obj.x_board + coluna]  = tetrominoes_obj.color;
            }
        }
    }
    verificarLinha();
    atualizarScore();
    layoutTetris();
}

// SCORE E REMOVER LINHAS 
function verificarLinha() { //verificar linhas do tabuleiro
    sequenciaLinhas = 0;
    for (let linha = 0; linha < N_ROW; linha++) {
        let linhaCompleta = true; //variavel que representa se a linha esta completa
        for (let coluna = 0; coluna < N_COL; coluna++){
            const corQuadrado = tabuleiro[linha][coluna]; 
            linhaCompleta = linhaCompleta && (corQuadrado !== backgroundTab) //verifica se a linha esta completa
        }
        if (linhaCompleta){ //se a linha estiver completa
            sequenciaLinhas++;
            atualizarLinha(linha); //atualiza linha (elimina)
            contLinhas(); //atualiza a quantidade de linhas eliminadas no placar
        }
    }
}
function atualizarLinha(linha){ //atualizar caso tenha uma linha completa (deletar a mesma) e somar no score
    for (let y = linha; y > 1; y--){
        for (let coluna = 0; coluna < N_COL; coluna++){
            tabuleiro[y][coluna] = tabuleiro[y - 1][coluna]; //remove a linha
        }
    }
    for (let coluna = 0; coluna < N_COL; coluna++){
        tabuleiro[0][coluna] = backgroundTab; //'pintando' a primeira linha
    }
}
function contLinhas() { //mostra a quantidade total de linhas eliminadas
    qtdLinhas++;
    var mostrarLinhas = qtdLinhas.toString();
    document.getElementById('linhaseliminadas').innerHTML = mostrarLinhas;
}
function atualizarScore() { //atualiza o placar de pontuacao
    score += (sequenciaLinhas*10) * sequenciaLinhas; //numero de linhas eliminadas * 10 pontos * (bonus)
    var mostrarScore = score.toString();
    document.getElementById('score').innerHTML = mostrarScore;
}

// TEMPORIZADOR JOGO 
function startTimer(){
    timerPlayer = setInterval(() => { timer(); }, timerMilesimos);
}
function stopTimer(){
    clearInterval(timerPlayer);
}
function timer(){
    seconds++; //Incrementa +1 na variável seconds

    if (seconds == 59) { //Verifica se deu 59 segundos
        seconds = 0; //Volta os segundos para 0
        minutes++; //Adiciona +1 na variável minutes

        if (minutes == 59) { //Verifica se deu 59 minutos
            minutes = 0;//Volta os minutos para 0
        
        }
    }
    
//Cria uma variável com o valor tratado MM:SS
var format = (minutes< 10 ? '0' + minutes: minutes) + ':' + (seconds< 10 ? '0' + seconds: seconds);
    
//Insere o valor tratado no elemento counter
document.getElementById('tempo').innerText = format;

//Retorna o valor tratado
return format;

}

// ----------- Reiniciar Game  ------------
function restartGame(){

    choiceJogaNovamente();//função que solicita ao usuário possível reinicialização do game
}

function choiceJogaNovamente(){
    var tabTAM = prompt("DESEJA JOGAR NOVAMENTE?\n𝟭 - Tabuleiro Clássico \n𝟮 - Tabuleiro Personalizado");
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
    startTimer(); //inicia o cronomêtro
}
// ----------- Habilita Botão Reinciar Game ------------
function habilitaRestart(){
    document.getElementById("restart-btn").style.display = "inline";
}