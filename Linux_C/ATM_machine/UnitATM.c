#include <stdlib.h>
#include <stdio.h>
#include <string.h>
#include <unistd.h>
#include <fcntl.h>
#include <time.h>
#include "UnitATM_tools.h"

int main(int argc, char *argv[])
{
        // Parametry domyślne
        int scale = 0;
        int descriptor = -1;
        int resources[3] = {0, 0, 0};
        unsigned int seed = getpid();
        double delay = 1.0;
        int pow10 = 1;

        // sprawdzenie argumentow na wejsciu
        if (parse_arguments(argc, argv, &scale, &descriptor, resources, &seed, &delay) == -1)  return 1;

        // potega w petli bo inaczej wyrzucalo blad
        for (int i = 0; i < scale; i++)
        {
                pow10 *= 10;
        }
        printf("Mnoznik/skala: 10^%d\n", pow10);
        printf("Opoznienie: %f sekund\n", delay);

        // generator liczb losowych
        srand(seed);

        char buffer[256];
        while (fgets(buffer, sizeof(buffer), stdin))
        {
                char *endptr;
                long value = strtol(buffer, &endptr, 10);

                // strspn - znajduje pasujace znaki
                if (strspn(buffer, " \t\n") == strlen(buffer)) continue;

                // koniec wiersza
                buffer[strcspn(buffer, "\n")] = '\0';

                // usuwanie bialych znakow
                if (*endptr != '\0' && strspn(endptr, " \t\n") != strlen(endptr))
                {
                        fprintf(stderr, "BLAD: Podaj jedna liczbe.");
                        continue;
                }
                
                if (value < 0)
                {
                        fprintf(stderr, "BLAD: Podaj nieujemna wartosc!");
                        continue;
                }
                printf("Pobrana kwota: %ld\n", value);

                // zetony
                printf("Żetony:\n");

                int tokens[3] = {0, 0, 0};
                int change = calculate_tokens(value, pow10, resources, tokens);
                display_token_value(descriptor, tokens, pow10, delay);

                // reszta
                printf("%d\n", change);
                printf("-----------\n");
        }
        printf("\n");
        return 0;
}
