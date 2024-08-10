import { useEffect, useState } from "react";
import useModal from "../../components/global/modal/hooks/useModal";
import ThemeForm from "../../components/themes/theme-form/ThemeForm";
import ThemesGrid from "../../components/themes/theme-grid/ThemesGrid";
import { Theme } from "../../models/Theme";
import useAPI from "../../api/useAPI";
import VisaoBasica from "../../components/global/visao-basica/VisaoBasica";

export default function ThemesPage() {

    const { HandleOpenModal } = useModal();
    const [data, setData] = useState<Theme[]>([]);

    const { getThemes } = useAPI();

    const fetchAPI = () => {
        getThemes().then( dados => setData(dados) );
    }

    useEffect(() => {
        fetchAPI();
    }, []);



    return (
        <VisaoBasica menuAtivo="Themes">
            <div className="container">
                <div className="page-title">
                    <h1>Themes</h1>
                    <button className="btn btn-primary" onClick={ e => HandleOpenModal(<ThemeForm options={{ onRefresh: fetchAPI }} />) }>Add new theme</button>
                </div>
                <ThemesGrid themes={data} options={{ onRefresh: fetchAPI }} />
            </div>
        </VisaoBasica>
    );
}