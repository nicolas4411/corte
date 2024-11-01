<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anotações das Facas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(246, 249, 250);
            padding: 20px;
            max-width: 400px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #6200EE;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3700B3;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
</head>

<body>
    <h2>Anotações das Facas</h2>
    <div id="facas">
        <h3>Adicionar faca</h3>
        <form id="formfacas" class="form-container">
            <input type="text" id="textcliente" placeholder="Nome do Cliente" required>
            <input type="number" id="numbermedida1" placeholder="Digite a medida 1" required>
            <input type="number" id="numbermedida2" placeholder="Digite a medida 2" required>
            <input type="text" id="textdescricao" placeholder="Digite a descrição da faca" required>
            <input type="date" id="datefaca" required>
            <input type="number" id="numberos" placeholder="Digite o número da OS" required>
            <input type="hidden" id="inputOperador">
            <button type="submit">Adicionar faca</button>
        </form>

        <a href="menu.php"><br>
            <button>VOLTAR</button>
        </a><br><br>

        <button id="exportarDados">Exportar Dados para Excel</button><br>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.5/firebase-app.js";
        import { getFirestore, collection, addDoc, getDocs } from "https://www.gstatic.com/firebasejs/10.12.5/firebase-firestore.js";
        import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.12.5/firebase-auth.js";

        const configuracaoFirebase = {
            apiKey: "AIzaSyAzgzdAXxswUjI3muUc0DYa3Sf4zY96uiE",
            authDomain: "lista-ebf73.firebaseapp.com",
            projectId: "lista-ebf73",
            storageBucket: "lista-ebf73.appspot.com",
            messagingSenderId: "13759953425",
            appId: "1:13759953425:web:68a3a233247cef4dde8fb0"
        };

        const app = initializeApp(configuracaoFirebase);
        const db = getFirestore(app);
        const auth = getAuth(app);

        let usuarioAtual = null;

        onAuthStateChanged(auth, (user) => {
            if (user) {
                usuarioAtual = user;
                document.getElementById('inputOperador').value = user.displayName || user.email;
            } else {
                usuarioAtual = null;
                alert("Você precisa estar logado para adicionar facas.");
            }
        });

        document.getElementById('formfacas').addEventListener('submit', async function (evento) {
            evento.preventDefault();
            const nome = document.getElementById('textcliente').value;
            const medida1 = parseFloat(document.getElementById('numbermedida1').value);
            const medida2 = parseFloat(document.getElementById('numbermedida2').value);
            const descricao = document.getElementById('textdescricao').value;
            const data = document.getElementById('datefaca').value;
            const os = parseFloat(document.getElementById('numberos').value);
            const operador = document.getElementById('inputOperador').value;

            if (usuarioAtual) {
                try {
                    await addDoc(collection(db, 'facas'), {
                        nome,
                        medida1,
                        medida2,
                        descricao,
                        data,
                        os,
                        operador,
                        timestamp: new Date() // Adiciona o timestamp
                    });
                    alert('Faca adicionada com sucesso!');
                    document.getElementById('formfacas').reset();
                } catch (erro) {
                    console.error('Erro ao adicionar faca:', erro);
                    alert('Erro ao adicionar faca.');
                }
            } else {
                alert("Você precisa estar logado para adicionar facas.");
            }
        });

        document.getElementById('exportarDados').addEventListener('click', async function () {
            const facasRef = collection(db, 'facas');
            const snapshot = await getDocs(facasRef);
            const dados = snapshot.docs.map(doc => {
                const data = doc.data();
                // Retira o campo timestamp
                const { timestamp, ...resto } = data;
                return { id: doc.id, ...resto };
            });

            // Cria um novo array com a ordem desejada
            const dadosOrdenados = dados.map(item => ({
                nome: item.nome,
                descricao: item.descricao,
                medida1: item.medida1,
                medida2: item.medida2,
                operador: item.operador,
                os: item.os,
                data: item.data,
            }));

            // Cria uma nova planilha
            const worksheet = XLSX.utils.json_to_sheet(dadosOrdenados);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Facas");

            // Gera um arquivo Excel e faz o download
            XLSX.writeFile(workbook, "facas_data.xlsx");
        });
    </script>
</body>

</html>