import { useEffect, useState } from "react";
import useModal from "./hooks/useModal";

export default function Modal() {

    const { animationType, isModalOpen, modalContent, HandleCloseModal, animationState } = useModal();

    const [animacao, setAnimacao] = useState('');

    useEffect(() => {
        switch (animationState) {
            case 'abrindo':
                setAnimacao(animationType + 'In');
                break;
            case 'aberto':
                setAnimacao(animationType + 'In');
                break;
            case 'fechando':
                setAnimacao(animationType + 'Out');
                break;
            case 'fechado':
                setAnimacao('');
                break;
        }
    }, [animationState]);

    if (!isModalOpen) return <></>;

    return (
        <div className={`modal ${animacao}`}>
            <div className="background" onClick={HandleCloseModal}></div>
            <div className="content">
                {modalContent}
            </div>
        </div>
    );
}