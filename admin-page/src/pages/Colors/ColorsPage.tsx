import { useEffect, useState } from "react";
import useAPI from "../../api/useAPI";
import VisaoBasica from "../../components/global/visao-basica/VisaoBasica";
import ColorGrid from "../../components/colors/color-grid/ColorGrid";
import { Color } from "../../models/Color";

export default function ColorsPage() {
    const [data, setData] = useState<Color[]>([]);

    const { getColors } = useAPI();

    const fetchAPI = () => {
        getColors().then( dados => setData(dados) );
    }

    useEffect(() => {
        fetchAPI();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);



    return (
        <VisaoBasica menuAtivo="Colors">
            <div className="container">
                <div className="page-title">
                    <h1>Colors</h1>
                </div>
                <ColorGrid colors={data} options={{ onRefresh: fetchAPI }} />
            </div>
        </VisaoBasica>
    );
}