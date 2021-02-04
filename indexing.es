PUT annotations/anno/1
{
    "canvas": "https://lab.library.universiteitleiden.nl/manifests/external/louvre/e-7851/canvas/recto",
    "canvas_label": "P. Louvre E 7851 Recto",
    "manifest": "https://lab.library.universiteitleiden.nl/manifests/external/louvre/e-7851.json",
    "manifest_label": "P. Louvre E 7851",
    "type": "Date",
    "transliteration": "26",
    "translation": "twenty six",
    "svg": "https://lab.library.universiteitleiden.nl/abnormalhieratic/wp-content/uploads/2018/10/r1twentysix.svg",
    "created": "2018-10-23T13:58:51",
    "motivation": ["painting", "sc:painting"],
    "x": 1749,
    "y": 676,
    "w": 138,
    "h": 121,
    "annotator": "Juan José Archidona Ramírez",
    "image_base_url": "https://lab.library.universiteitleiden.nl/iiif/2/Louvre_E_7851_recto.jpg",
    "image_full_url": "https://lab.library.universiteitleiden.nl/iiif/2/Louvre_E_7851_recto.jpg/1749,676,138,121/full/0/default.jpg"
}

GET annotations/_settings

GET annotations/_mapping

GET annotations/anno/1

GET annotations/_search?q=twenty+six

GET annotations/_search?q=type:date

PUT annotations/anno/2
{
    "canvas": "https://lab.library.universiteitleiden.nl/manifests/external/louvre/e-7851/canvas/recto",
    "canvas_label": "P. Louvre E 7851 Recto",
    "manifest": "https://lab.library.universiteitleiden.nl/manifests/external/louvre/e-7851.json",
    "manifest_label": "P. Louvre E 7851",
    "type": "Verb",
    "transliteration": "ḏd",
    "translation": "Have said",
    "svg": "https://lab.library.universiteitleiden.nl/abnormalhieratic/wp-content/uploads/2018/10/r2Dd.svg",
    "created": "2018-10-23T14:03:56",
    "motivation": ["painting", "sc:painting"],
    "x": 1900,
    "y": 842,
    "w": 126,
    "h": 112,
    "annotator": "Juan José Archidona Ramírez",
    "image_base_url": "https://lab.library.universiteitleiden.nl/iiif/2/Louvre_E_7851_recto.jpg",
    "image_full_url": "https://lab.library.universiteitleiden.nl/iiif/2/Louvre_E_7851_recto.jpg/1900,842,126,112/full/0/default.jpg"
}