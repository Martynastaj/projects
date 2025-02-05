import string
DANE='''Lorem ipsum dolor sit mi leo felis vitae arcu sed felis.
 Nulla iaculis arcu a erat. Nullam et magnis dis parturient montes, nascetur 
ridiculus mus. Praesent ac diam. Aenean facilisis hendrerit. Donec ut eros. 
Sed diam lectus, eu cursus ligula nunc, luctus et malesuada fames ac 
dignissim turpis. Praesent a leo vitae augue. 
Sed dignissim vitae, cursus eu, iaculis in, elementum euismod, quam 
eu odio. Morbi dignissim, nulla in dictum sed,
 vestibulum et, lobortis sed, neque. Etiam aliquet, 
purus convallis cursus tristique, mauris nec odio. 
Aliquam risus eu mi. Pellentesque habitant morbi 
tristique eget, porta ornare, orci mauris eget sapien 
mauris magna, at metus. Quisque et felis sollicitudin 
justo. Curabitur gravida ullamcorper ultrices posuere 
commodo, odio nec tincidunt wisi, mollis nulla in erat 
volutpat. Nunc id magna. Nullam dui turpis gravida vel, 
eros. Sed orci dui, in erat sit amet justo. Integer
 aliquet eget, pede. Duis luctus, enim urna, egestas volutpat. Curabitur
 tempor. Quisque quis suscipit congue et, accumsan vitae, vehicula 
ullamcorper, augue quis venenatis nulla ut leo. Maecenas eu ante. 
Phasellus blandit, quam. Donec enim vel odio. Nam.
'''
def normalizacja(tekst):
    trans=str.maketrans('', '', string.punctuation)
    TEKST=tekst.translate(trans)
    TEKST=TEKST.lower()
    return TEKST

normalizacja(DANE)
