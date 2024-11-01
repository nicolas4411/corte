<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(246, 249, 250);
            margin: 0;
            padding: 0;
        }

        /* Estilo do cabeçalho */
        .header {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            justify-content: center;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 18px;
            justify-content: center;
        }

        .inicio {
            max-width: 400px;
        }

        /* Container principal */
        .container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            background-color: white;
        }

        /* Formulário */
        .form-container {
            margin-bottom: 20px;
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
            margin-top: 10px;
        }

        button:hover {
            background-color: #3700B3;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 20px;
            }

            .header h3 {
                font-size: 16px;
            }

            button {
                font-size: 14px;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 18px;
            }

            .header h3 {
                font-size: 14px;
            }

            button {
                font-size: 12px;
            }

            input {
                padding: 8px;
            }
        }
    </style>

</head>

<body>

    <div class="container">
        <!-- Container de autenticação -->
        <div id="authContainer" class="form-container">
            <h1>Login</h1>
            <form id="formLogin">
                <input type="email" id="inputEmail" placeholder="E-mail" required>
                <input type="password" id="inputSenha" placeholder="Senha" required>
                <input type="text" id="inputoperador" placeholder="Operador" required>
                <button type="submit">Login</button>
            </form>
            <button id="botaoCadastro">Cadastrar Novo Usuário</button>
        </div>

        <!-- Container de CRUD de orçamentos -->
        <div id="crudContainer" style="display: none;">
            <div id="inicio">
                <h1>CORTE ESPECIAL</h1>
                <h3>Controle De Produção</h3>
            </div>

            <a href="faca.php">
                <button>Facas</button>
            </a>

            <button id="botaoLogout">Logout</button>
        </div>
    </div>

    <script type="module">
        import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.5/firebase-app.js";
        import { getFirestore, collection, addDoc, getDocs, updateDoc, deleteDoc, doc, query, where } from
            "https://www.gstatic.com/firebasejs/10.12.5/firebase-firestore.js";
        import { getAuth, signInWithEmailAndPassword, createUserWithEmailAndPassword, signOut, onAuthStateChanged } from
            "https://www.gstatic.com/firebasejs/10.12.5/firebase-auth.js";

        // Configurações do Firebase
        const configuracaoFirebase = {
            apiKey: "AIzaSyAzgzdAXxswUjI3muUc0DYa3Sf4zY96uiE",
            authDomain: "lista-ebf73.firebaseapp.com",
            databaseURL: "https://lista-ebf73-default-rtdb.firebaseio.com",
            projectId: "lista-ebf73",
            storageBucket: "lista-ebf73.appspot.com",
            messagingSenderId: "13759953425",
            appId: "1:13759953425:web:68a3a233247cef4dde8fb0"
        };

        // Inicializar Firebase
        const app = initializeApp(configuracaoFirebase);
        const db = getFirestore(app);
        const auth = getAuth(app);

        let usuarioAtual = null;

        // Função de autenticação de usuários
        document.getElementById('formLogin').addEventListener('submit', async function (evento) {
            evento.preventDefault();
            const email = document.getElementById('inputEmail').value;
            const senha = document.getElementById('inputSenha').value;
            const operador = document.getElementById('inputoperador').value;
            try {
                await signInWithEmailAndPassword(auth, email, senha);
                alert('Login bem-sucedido!');
            } catch (erro) {
                console.error('Erro ao fazer login:', erro);
                alert('Erro ao fazer login. Verifique suas credenciais.');
            }
        });

        // Função de cadastro de usuários
        document.getElementById('botaoCadastro').addEventListener('click', async function () {
            const email = prompt('Digite o e-mail para cadastro:');
            const senha = prompt('Digite a senha para cadastro:');
            if (email && senha) {
                try {
                    await createUserWithEmailAndPassword(auth, email, senha);
                    alert('Usuário cadastrado com sucesso!');
                } catch (erro) {
                    console.error('Erro ao cadastrar usuário:', erro);
                    alert('Erro ao cadastrar usuário.');
                }
            }
        });

        // Função de logout
        document.getElementById('botaoLogout').addEventListener('click', async function () {
            try {
                await signOut(auth);
                alert('Logout realizado com sucesso!');
            } catch (erro) {
                console.error('Erro ao fazer logout:', erro);
                alert('Erro ao fazer logout.');
            }
        });

        // Função para verificar o estado de autenticação do usuário
        onAuthStateChanged(auth, (usuario) => {
            usuarioAtual = usuario;
            if (usuario) {
                document.getElementById('authContainer').style.display = 'none';
                document.getElementById('crudContainer').style.display = 'block';
                carregarOrcamentos();
            } else {
                document.getElementById('authContainer').style.display = 'block';
                document.getElementById('crudContainer').style.display = 'none';
            }
        });

        // Função para exportar os dados
        document.getElementById('exportarDados').addEventListener('click', async function () {
            const facasRef = collection(db, 'facas');
            const snapshot = await getDocs(facasRef);
            const dados = snapshot.docs.map(doc => ({ id: doc.id, ...doc.data() }));

            // Ordena os dados pela timestamp
            dados.sort((a, b) => a.timestamp - b.timestamp);

            // Cria uma nova planilha
            const worksheet = XLSX.utils.json_to_sheet(dados);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Facas");

            // Gera um arquivo Excel e faz o download
            XLSX.writeFile(workbook, "facas_data.xlsx");
        });
    </script>

</body>

</html>