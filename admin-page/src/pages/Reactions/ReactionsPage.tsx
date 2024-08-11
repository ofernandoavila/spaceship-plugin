import useModal from "../../components/global/modal/hooks/useModal";
import ThemeForm from "../../components/themes/theme-form/ThemeForm";
import VisaoBasica from "../../components/global/visao-basica/VisaoBasica";

export default function ReactionsPage() {

    const { HandleOpenModal } = useModal();

    return (
        <VisaoBasica menuAtivo="Reactions">
            <div className="container">
                <div className="page-title">
                    <h1>Reactions</h1>
                    <button className="btn btn-primary" onClick={ e => HandleOpenModal(<ThemeForm />) }>Add new reaction</button>
                </div>
            </div>
        </VisaoBasica>
    );
}