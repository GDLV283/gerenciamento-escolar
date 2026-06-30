CREATE DATABASE IF NOT EXISTS agenda_compromissos CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE agenda_compromissos;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS agenda (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    local_compromisso VARCHAR(100) NOT NULL,
    data_compromisso DATETIME NOT NULL,
    horario TIME NOT NULL,
    status_evento VARCHAR(30) NOT NULL,
    observacoes TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    imagem VARCHAR(255) NULL,
    usuario_id INT NOT NULL,
    CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);
INSERT INTO usuarios (nome, email, senha) VALUES
('Usuário Demo', 'usuario@exemplo.com', '$2y$10$vi8n4rDnaEnntzgwsD0pmuHnEzo73QmA1WLJYN047g.FBAQCeN46i'),
('Gab', 'gabylimavieira06@gmail.com', '$2y$10$vi8n4rDnaEnntzgwsD0pmuHnEzo73QmA1WLJYN047g.FBAQCeN46i')
ON DUPLICATE KEY UPDATE
nome = VALUES(nome),
senha = VALUES(senha);
INSERT INTO agenda (nome, local_compromisso, data_compromisso, horario, status_evento, observacoes, usuario_id) VALUES
('Prova Matemática', '2 andar, IFRS', '2026-06-15', '19:30', 'Concluído', 'Prova Matemática; Estudar regra de 3!', 1),
('Ir comprar comida', 'Padaria perto da rotatoria', '2026-07-20', '14:32', 'Pendente', 'Ir no mercadinho; Comprar mais frutas.', 1),
('Trabalho feito', 'Via Moodle', '2026-08-03', '21:32', 'Concluído', 'Entrega do trabalho.', 1),
('Trabalho feito de Programação', 'Via Moodle', '2026-01-07', '21:32', 'Concluído', 'Entrega do trabalho.', 2);
