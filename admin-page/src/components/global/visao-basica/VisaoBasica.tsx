import { ReactNode } from "react";
import './_visao-basica.scss';
import { useNavigate } from "react-router-dom";

interface IVisaoBasicaProps {
    children: ReactNode;
    menuAtivo?: string;
}

export default function VisaoBasica({ children, menuAtivo }: IVisaoBasicaProps) {

    const navigate = useNavigate();

    return (
        <>
            <header>
                <div className="container">
                    <h1>Spaceship Plugin</h1>
                    <ul className="menu-nav">
                        <li onClick={() => navigate('/')} className={ menuAtivo ? menuAtivo === 'Themes' ? 'ativo' : '' : '' }>Themes</li>
                        <li onClick={() => navigate('/colors')} className={ menuAtivo ? menuAtivo === 'Colors' ? 'ativo' : '' : '' }>Colors</li>
                    </ul>
                </div>
            </header>
            <main>
                { children }
            </main>
        </>
    );
}