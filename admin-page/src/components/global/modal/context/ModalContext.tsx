import { createContext, ReactNode, useState } from "react";
import Modal from "../Modal";

interface ModalContextData {
    isModalOpen: boolean;
    modalContent: JSX.Element | null;
    HandleCloseModal: () => void;
    HandleOpenModal: (element: JSX.Element, type?: ModalAnimacaoType) => void;

    animationType: ModalAnimacaoType;
    animationState: 'aberto' | 'abrindo' | 'fechando' | 'fechado';
    setAnimationType: React.Dispatch<React.SetStateAction<"fade" | "move">>;
}

export type ModalAnimacaoType = "fade" | "move";

interface ModalContextProviderProps {
    children: ReactNode;
}

export const ModalContext = createContext({} as ModalContextData);

export default function ModalContextProvider({ children }: ModalContextProviderProps) {
    
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [modalContent, setModalContent] = useState<JSX.Element | null>(null);

    const [animationType, setAnimationType] = useState<ModalAnimacaoType>('fade');
    const [animationState, setAnimationState] = useState<'aberto' | 'abrindo' | 'fechando' | 'fechado'>('fechado');
    
    const closeModal = () => {
        setModalContent(null);
        setIsModalOpen(false);
    }

    const HandleCloseModal = () => {
        setAnimationState('fechando');
        setTimeout(() => {
            closeModal();
            setAnimationState('fechado');
        }, 300);
    }
    
    const HandleOpenModal = (element: JSX.Element, type?: ModalAnimacaoType) => {
        if(type !== undefined) {
            setAnimationType(type);
        } else {
            setAnimationType('fade');
        }
        setIsModalOpen(true);
        setModalContent(element);
        setAnimationState('abrindo');
        setTimeout(() => {
            setAnimationState('aberto');
        }, 1000);
    }
    
    return (
        <ModalContext.Provider value={{ animationState, animationType, setAnimationType, HandleOpenModal, isModalOpen, HandleCloseModal, modalContent }} >
            <Modal />
            { children }
        </ModalContext.Provider>
    );
}