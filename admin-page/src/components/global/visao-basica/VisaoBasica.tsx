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
                    <div className="header-title">
                        <h1>Spaceship Plugin</h1>
                        <small>version { process.env.REACT_APP_VERSION }</small>
                    </div>
                    <ul className="menu-nav">
                        <li onClick={() => navigate('/')} className={ menuAtivo ? menuAtivo === 'Themes' ? 'ativo' : '' : '' }>Themes</li>
                        <li onClick={() => navigate('/reactions')} className={ menuAtivo ? menuAtivo === 'Reactions' ? 'ativo' : '' : '' }>Reactions</li>
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