import { useEffect, useState } from "react";
import { Color } from "../../../models/Color";

interface IColorPickerProps {
    value: Color | null;
    setValue: (value: Color) => void;
}

export default function ColorPicker({ value, setValue }: IColorPickerProps) {
    const [selected, setSelected] = useState<Color | null>(null);
    const [isListOpen, setIsListOpen] = useState(false);
    const colors: Color[] = [
        {
            "id": 1,
            "description": "Red",
            "value": "#fe3152"
        },
        {
            "id": 2,
            "description": "Orange",
            "value": "#f39c11"
        },
        {
            "id": 3,
            "description": "Yellow",
            "value": "#ffd011"
        },
        {
            "id": 4,
            "description": "Green",
            "value": "#27ae61"
        },
        {
            "id": 5,
            "description": "Light Blue",
            "value": "#3598db"
        },
        {
            "id": 6,
            "description": "Blue",
            "value": "#297fb8"
        },
        {
            "id": 7,
            "description": "Purple",
            "value": "#9a59b5"
        },
        {
            "id": 8,
            "description": "Dark",
            "value": "#333333"
        },
        {
            "id": 9,
            "description": "Gray",
            "value": "#d2d2d2"
        },
        {
            "id": 10,
            "description": "White",
            "value": "#ecf0f1"
        },
        {
            "id": 11,
            "description": "Gold",
            "value": "#ffc225"
        }
    ];

    useEffect(() => {
        if(value) {
            setSelected(value);
        }
    }, [value]);

    const HandleOnSelectColor = (color: Color) => {
        setSelected(color);
        setIsListOpen(false);
        setValue(color);
    }

    return (
        <div className="color-picker">
            <div className="color-select" onClick={ e => setIsListOpen(!isListOpen) }>
                <input type="hidden" name="SSP_Theme_colorId" value="0" />
                { selected ? <div className="color-sample" style={{ backgroundColor: selected.value }}></div> : '' }
                <span className="color-name">{ selected ? selected.description : 'Select a color' }</span>
            </div>
            { isListOpen ? (
                <ul className="color-list">
                    { colors.map( color => (
                        <li className="color-item" onClick={ e => HandleOnSelectColor(color) }>
                            <div className="color-sample" style={{ backgroundColor: `${color.value}` }}></div>
                            <span className="color-name">{ color.description }</span>
                        </li>
                    )) }
                </ul>
            ) : '' }
        </div>
    );
}