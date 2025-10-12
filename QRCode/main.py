import qrcode
from qrcode.image.styledpil import StyledPilImage
from qrcode.image.styles.moduledrawers import RoundedModuleDrawer
from qrcode.image.styles.colormasks import SolidFillColorMask


uuid = "01234567-89ab-cdef-0123-456789abcdef"

    
qr = qrcode.QRCode(
    version=1,  # taille du QR code : 1 = 21x21, 2 = 25x25, etc.
    error_correction=qrcode.constants.ERROR_CORRECT_H,  # tolérance d'erreurs élevée
    box_size=10,  # taille d'un carré
    border=4,    # épaisseur de la bordure
)

qr.add_data(uuid)
qr.make(fit=True)

# Personnalisation du style
img = qr.make_image(
    image_factory=StyledPilImage,
    color_mask=SolidFillColorMask(back_color=(52, 33, 130), front_color=(0,0,0))  # couleur avant/arrière
)

filename = f"custom_qr.png"
img.save(filename)