LITERY=grupowanie_slow(TEXT)

def grupowanie_slownikow(LITERY):
    SAMOGLOSKI = {}

    while LITERY:
        key, value = LITERY.popitem()
        vowels = set()
        for char_set in key:
            for char in char_set:
                if char in 'aeiouyAEIOUY':
                    vowels.add(char)
        vowels_key = frozenset(vowels)
        SAMOGLOSKI.setdefault(vowels_key, []).append(value)

    return SAMOGLOSKI

SAMOGLOSKI=grupowanie_slownikow(LITERY)
